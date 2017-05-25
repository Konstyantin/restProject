;(function ($, undefined) {

    /**
     * Store base setting (host|documentRoot|http|route) and setters and getters
     */
    var settings = {

        host: 'dcodeit.net',
        documentRoot: '/kostya.nagula/project/restProject/',
        http: 'http://',
        route: 'index',

        token: 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0=',

        /**
         * Set route
         *
         * @param route
         */
        setRouute: function (route) {
            this.route = route;
        },


        /**
         * Get current route
         *
         * @returns {string}
         */
        getRoute: function () {
            return window.location.href;
        },

        /**
         * Get stored path to project
         *
         * @returns {string}
         */
        getPath: function () {
            return this.http + this.host + this.documentRoot + this.route;
        }
    };

    /**
     * Stored template components
     */
    var templateComponent = {
        postUpdateBtn: '<div class="post-manage-item update-btn"><a href="#" class="btn btn-primary update-post">Update</a></div>',
        postUpdateTitleField: '<div class="post-update-title-field"><input type="text" name="title" placeholder="title" class="form-control"></div>',
        postUpdateContentField: '<div class="post-update-content-field"><input type="text" name="content" placeholder="content" class="form-control"></div>',
    };

    /**
     * Event class
     *
     * Store event which use for update delete and create new posts
     *
     * @constructor
     */
    function Event() {

        // inherit template component
        this.__proto__ = templateComponent;

        // call methods
        this.init = function () {
            this.update();
            this.create();
            this.delete();
        };

        this.request = new Request();

        var that = this,
            container = $('.post-container-list'),   //container which store post
            postItem = container.find('.post-item'), //posts
            deleteBtn = postItem.find('.btn-danger');

        // update post
        this.update = function () {

            postItem.on('click', function () {

                var $this = $(this);

                $this.siblings('.post-item').removeClass('active');
                $this.addClass('active');


                $.each(postItem, function () {
                    that.destroyUpdateFiled(this);
                });

                if ($this.hasClass('active')) {
                    return that.buildUpdateField($this);
                }
            });
        };

        // delete post
        this.delete = function () {
            deleteBtn.on('click', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),
                    postId = post.attr('id');

                post.remove();

                that.request.sendRequest('post/' + postId, null, 'DELETE');
            })
        };

        this.create = function () {

        };

        /**
         * Build update field
         *
         * Add fields which user for update post item data
         *
         * @param post
         */
        this.buildUpdateField = function (post) {
            var titleBlock = post.find('.post-item-title'),
                contentBlock = post.find('.post-item-content'),
                manageBlock = post.find('.post-manage-list');

            titleBlock.append(that.postUpdateTitleField);
            contentBlock.append(that.postUpdateContentField);
            manageBlock.append(that.postUpdateBtn);
        };

        /**
         * Destroy update field
         *
         * Remove field which use for update post item
         *
         * @param post
         */
        this.destroyUpdateFiled = function (post) {

            var post = $(post),
                titlePostField = post.find('.post-update-title-field'),
                contentPostField = post.find('.post-update-content-field'),
                updatePostBtn = post.find('.update-btn');

            if (titlePostField.length && contentPostField.length && updatePostBtn.length) {
                titlePostField.remove();
                contentPostField.remove();
                updatePostBtn.remove();
            }
        }
    }

    function Request() {

        this.__proto__ = settings;

        this.sendRequest = function (route, data = null, method) {

            var that = this;

            that.setRouute(route);

            $.ajax({
                url: that.getPath(),
                type: method,
                beforeSend: function(xhr){xhr.setRequestHeader('X-AUTH_TOKEN', that.token)},
                success: function (data) {
                    console.log(data);
                }
            });
        };
    }

    function ClientREST() {

    }
    
    var event = new Event();

    event.init();


})(jQuery);