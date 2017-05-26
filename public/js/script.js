;(function ($, undefined) {

    /**
     * Base settings which store host, pathDir, route, token
     */
    var settings = {
        host: 'dcodeit.net',
        pathDir: '/kostya.nagula/project/restProject/',
        route: 'index',

        token: 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0='
    };

    /**
     * Stored template component for dynamic element
     */
    var template = {
        postContent: '<div><input type="text" class="form-control post-content-field" placeholder="Content"></div>',
        postTitle: '<div><input type="text" class="form-control post-title-field" placeholder="Title"></div>',
        postUpdateBtn: '<div><a href="" class="btn btn-primary update-post-btn">Update</a></div>',
        postCreateForm: '<div class="add-post-form clearfix"><div class="col-lg-3 post-form-field"><input type="text" class="form-control create-post-title-field" placeholder="Title"></div><div class="col-lg-3 post-form-field"><input type="text" class="form-control create-post-content-field" placeholder="Content"></div><a href="" class="btn btn-success create-post-btn">Create</a></div>'
    };

    /**
     * Class Event
     *
     * Component which use for manage post
     *
     * @constructor
     */
    function Event() {

        // request class which use for send request
        this.request = new Request();

        var that = this,
            container = $('.post-container'),               // main container which store list of post
            postList = container.find('.post-item'),        // post list
            createBtn = container.find('.add-post-btn');    // add btn which add form for create new post

        // init manage event
        this.init = function () {
            this.update();
            this.create();
            this.delete();
        };

        /**
         * Update post method
         */
        this.update = function () {

            // attach event for dynamic button
            postList.on('click', '.edit-post-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),
                    postId = post.attr('id'),
                    route = 'post/' + postId;

                if (post.hasClass('active')) {
                    post.removeClass('active');
                    return that.deleteUpdateField(post);
                }

                // remove class active on list post items
                postList.removeClass('active');

                // delete edit form in active form field
                $.each(postList, function () {
                    var post = $(this);
                    that.deleteUpdateField(post);
                });

                // check is post have edit form field
                if (!that.checkUpdateField(post)) {
                    post.addClass('active');
                    that.buildUpdateField(post);
                }

                // attach click event for dynamic element
                postList.on('click', '.update-post-btn', function (e) {
                    e.preventDefault();

                    // get data from field
                    var data = that.getFormData(post),
                        $this = ($this);

                    that.deleteUpdateField(post);

                    // convert data to json
                    dataJson = JSON.stringify(data);

                    // send request
                    that.request.sendRequest(route, 'PUT', dataJson);

                    that.setPostData(post, data);
                });
            });
        };

        /**
         * Create post method
         */
        this.create = function () {

            // attach click event to add btn
            createBtn.on('click', function (e) {
                e.preventDefault();

                var addPostContainer = $('.add-post-container'); //container which will store field using for create new post

                // add field for create new post
                that.addPostForm(addPostContainer);

                // attach click event
                container.on('click', '.create-post-btn', function (e) {
                    e.preventDefault();

                    var title = container.find('.create-post-title-field').val(),       // get title value new post
                        content = container.find('.create-post-content-field').val();   // get content value new post

                    var data = {
                        'title': title,
                        'content': content
                    };

                    // convert data to JSON
                    data = JSON.stringify(data);

                    // send POST request
                    that.request.sendRequest('post', 'POST', data);
                });
            });
        };

        /**
         * Delete post method
         */
        this.delete = function () {

            // attach click event
            postList.on('click', '.delete-post-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),     // find current post
                    postId = post.attr('id'),               // get id current post
                    route = 'post/' + postId;               // route

                // send request
                that.request.sendRequest(route, 'DELETE');

                // remove post item
                post.remove();
            });
        }
    }

    /**
     * Class Request
     *
     * Component which use for manage request data
     *
     * @constructor
     */
    function Request() {

        // inherit setting property
        this.__proto__ = settings;

        /**
         * Get current route
         *
         * @returns {string}
         */
        this.getRoute = function () {
            return window.location.href;
        };

        /**
         * Set value for route property
         *
         * @param route
         */
        this.setRoute = function (route) {
            this.route = route;
        };

        /**
         * Get path route to project
         *
         * @returns {string}
         */
        this.getPath = function () {
            return 'http://' + this.host + this.pathDir + this.route;
        };

        /**
         * Send request
         *
         * Send ajax request by route, method and data
         *
         * @param route
         * @param method
         * @param data
         */
        this.sendRequest = function (route, method, data = null) {

            var that = this;

            that.setRoute(route);

            $.ajax({
                url: that.getPath(),                // set url for send request
                method: method,                     // set request method
                contentType: 'application/json',    // set content type
                dataType: 'json',                   // set data type
                data: data,                         // send data
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-AUTH_TOKEN', 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0=')    //set access token
                },
                success: function (data) {

                }
            });
        };

    }

    /**
     * Class FormEditor
     *
     * Component which use for build form field and get manage form data
     *
     * @constructor
     */
    function FormEditor() {

        this.__proto__ = template;

        /**
         * Check store update field
         *
         * @param post
         * @returns {boolean}
         */
        this.checkUpdateField = function (post) {
            var title = post.find('.post-title-field'),     // find post field
                content = post.find('.post-content-field'), // find content field
                updateBtn = post.find('.update-post-btn');  // find btn post

            // check exist fields into post item
            return (title.length && content.length && updateBtn.length) ? true : false;
        };

        /**
         * Delete edit field
         *
         * @param post
         */
        this.deleteUpdateField = function (post) {
            post.find('.post-title-field').remove();        // delete post title field
            post.find('.post-content-field').remove();      // delete post content field
            post.find('.update-post-btn').remove();         // delete post btn update
        };

        /**
         * Build update field for select post item
         *
         * @param post
         */
        this.buildUpdateField = function (post) {
            var titleContainer = post.find('.post-item-title'),         // find block witch must stored title field
                containerContainer = post.find('.post-item-content'),   // find block witch must stored content field
                postManageList = post.find('.post-manage-list');        // find block witch must stored btn

            titleContainer.append(this.postTitle);
            containerContainer.append(this.postContent);
            postManageList.append(this.postUpdateBtn);
        };

        /**
         * Get data from update field
         *
         * @param post
         * @returns {{title: *, content: *, author: (XMLList|*)}}
         */
        this.getFormData = function (post) {

            var title = post.find('.post-title-field').val(),
                content = post.find('.post-content-field').val(),
                updateBtn = post.find('.update-post-btn'),
                author = post.find('.author').text(),
                data = {};

            return data = {
                'title': title,
                'content': content,
                'author': author
            };
        };

        /**
         * Add post form
         *
         * @param container
         */
        this.addPostForm = function (container) {
            var child = container.children();

            if (!child.length) {
                container.append(this.postCreateForm);
            }
        };

        /**
         * Update post data
         *
         * @param post
         * @param data
         */
        this.setPostData = function (post, data) {
            var title = post.find('.post-title-value'),
                content = post.find('.post-content-value');

            title.text(data.title);
            content.text(data.content);
        }
    }

    /**
     * Event extend FormEditor
     *
     * @type {FormEditor}
     */
    Event.prototype = new FormEditor();

    function Client() {

        this.event = new Event();
        this.request = new Request();
        this.formEdit = new FormEditor();
        var path = this.request.getPath();

        this.run = function () {
            this.event.init();
        }
    }

    var client = new Client();

    client.run();

})(jQuery);