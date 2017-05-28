;(function ($, undefined) {

    /**
     * Base settings which store host, pathDir, route, token
     */
    var settings = {
        host: 'localhost',
        pathDir: '/',
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
            createBtn = container.find('.add-post-btn'),    // add btn which add form for create new post
            mainHeader = container.find('.main-header');    // main header page

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
            container.on('click', '.edit-post-btn', function (e) {
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
                container.on('click', '.update-post-btn', function (e) {
                    e.preventDefault();

                    // get data from field
                    var data = that.getFormData(post),
                        $this = ($this);

                    // check field data
                    if (that.checkEmptyData(data)) {

                        // delete update field
                        that.deleteUpdateField(post);

                        // convert data to json
                        dataJson = JSON.stringify(data);

                        // send request
                        that.request.sendRequest(route, 'PUT', dataJson);

                        that.setPostData(post, data);

                        post.removeClass('active');
                        // add success flash message
                        // mainHeader.after(that.addFlashMessage('success', 'success', 'Post update success'));
                    }

                    // add error flash message
                    // mainHeader.after(that.addFlashMessage('danger', 'Error', 'Data is empty'));
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

                    if (that.checkEmptyData(data)) {

                        // convert data to JSON
                        dataJson = JSON.stringify(data);

                        // send POST request
                        that.request.sendRequest('post', 'POST', dataJson);

                        addPostContainer.empty();

                        // return mainHeader.after(that.addFlashMessage('success', 'Success', 'Post created success'));
                    }

                    // return mainHeader.after(that.addFlashMessage('danger', 'Error', 'Data is not valid'));
                });
            });

            return null;
        };

        /**
         * Delete post method
         */
        this.delete = function () {

            // attach click event
            container.on('click', '.delete-post-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),     // find current post
                    postId = post.attr('id'),               // get id current post
                    route = 'post/' + postId;               // route

                // send request
                that.request.sendRequest(route, 'DELETE');

                // remove post item
                post.remove();

                mainHeader.after(that.addFlashMessage('success', 'Success', 'Post was deleted success'));
            });
        };

        /**
         * Get flash message
         *
         * @param status
         * @param subject
         * @param message
         * @returns {string}
         */
        this.addFlashMessage = function (status, subject, message) {
            return '<div class="alert alert-' + status + ' alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' + subject + ' </strong>' + message + '</div>'
        };
    }

    /**
     * Class Request
     *
     * Component which use for manage request data
     *
     * @constructor
     */
    function Request() {

        this.postList = null;

        this.postCount = null;

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
                data: data,
                headers: {
                    'content-type': 'application/json',
                    'X-AUTH_TOKEN': 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0='
                }
            });
        };

        this.getPostList = function (route) {
            var that = this;

            that.setRoute(route);

            $.ajax({
                url: that.getPath(),
                method: 'GET',
                success: function (data) {
                    data = JSON.parse(data);
                    that.postList = data.list;
                    that.postCount = data.count;
                }
            });
        };

        // this.sendUpdatePostList = function (route, postList) {
        //     var that = this;
        //
        //     that.setRoute(route);
        //
        //     // $.ajax({
        //     //     url: that.getPath(),
        //     //     method: 'POST',
        //     //     // data: {
        //     //     //     list: postList
        //     //     // },
        //     //     success: function (data) {
        //     //         console.log(data);
        //     //     }
        //     // });
        // }
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
                data = {};

            return data = {
                'title': title,
                'content': content,
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

        this.checkEmptyData = function (data) {
            return (data.title && data.content) ? true : false;
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

        this.run = function () {
            this.event.init();
        }
    }

    function LoadPost() {

        this.postDisplayList = [];

        this.offset = 20;

        this.route = 'change/' + this.offset;

        /**
         * Check bottom
         *
         * Check bottom scroll page after load new posts
         */
        this.checkBottom = function () {

            var scrollTop = $(window).scrollTop(),
                winHeight = $(window).height(),
                docHeight = $(document).height();

            if (scrollTop + winHeight == docHeight) {

                if (this.checkPostCount()) {
                    this.offset = this.offset + 20;

                    this.route = 'change/' + this.offset;

                    if (this.checkPostCount()) {
                        this.getPostList(this.route);
                    }

                    this.appendPost();
                }
            }
        };

        /**
         * Load post where scroll page
         */
        this.scrollPage = function () {

            var that = this;

            this.checkCalculatePostCount();

            $(window).scroll(function () {
                that.checkBottom();
            });
        };

        /**
         * Check calculate post count after make request and get post count
         */
        this.checkCalculatePostCount = function () {
            if (!this.postCount) {
                this.getPostList(this.route);
            }
        };

        /**
         * Check post count
         *
         * @returns {boolean}
         */
        this.checkPostCount = function () {
            return this.offset < this.postCount
        };

        /**
         * Append load post to post list
         */
        this.appendPost = function () {

            var tableBody = $('tbody');

            $.each(this.postList, function () {
                tableBody.append('' +
                    '<tr class="post-item" id="' + this.id + '">' +
                        '<td>' + this.id + '</td>' +
                        '<td class="post-item-title">' +
                            '<div class="post-title-value">' + this.title + '</div>' +
                        '</td>' +
                        '<td class="post-item-content">' +
                            '<div class="post-content-value">' + this.content + '</div>' +
                        '</td>' +
                        '<td class="author"> ' + this.author + '</td>' +
                        '<td>2017-03-21 15:44:43</td>' +
                        '<td class="post-manage-list">' +
                            '<div class="post-manage-item">' +
                                '<a href="" class="btn btn-danger delete-post-btn">Delete</a>' +
                                '<a href="" class="btn btn-success edit-post-btn dynamic-edit-btn">Edit</a>' +
                            '</div>' +
                        '</td>' +
                    '</tr>'
                );
            });

            this.getDisplayPost();
        };

        this.getDisplayPost = function () {
            var postContainer = $('.post-container'),
                postList = postContainer.find('.post-item'),
                listElem = [];

            $.each(postList, function () {
                listElem.push(this.id);
            });

            this.postDisplayList = listElem;

            // this.sendUpdatePostList('updateTime', listElem);
        };

        this.getDisplayPost();

        this.scrollPage();
    }

    LoadPost.prototype = new Request();

    var load = new LoadPost();

    var client = new Client();

    client.run();

})(jQuery);