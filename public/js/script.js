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
        setRoute: function (route) {
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
        postUpdateBtn: '<div class="post-manage-item"><a href="#" class="btn btn-primary update-post-btn">Update</a></div>',
        postUpdateTitleField: '<div><input type="text" name="title" placeholder="title" class="form-control title-post-input"></div>',
        postUpdateContentField: '<div><input type="text" name="content" placeholder="content" class="form-control content-post-input"></div>'
    };

    /**
     * Event class
     *
     * Store event which use for update delete and create new posts
     *
     * @constructor
     */
    function Event() {

        this.fieldComponent = new FieldComponent();

        // inherit template component
        this.__proto__ = templateComponent;

        // call methods
        this.init = function () {
            this.update();
            this.create();
            this.delete();
        };

        var that = this,
            container = $('.post-container'),
            listPost = container.find('.post-item'),
            deleteBtn = listPost.find('.delete-post-btn'),
            updateBtn = listPost.find('.edit-post-btn');

        this.update = function () {
            updateBtn.on('click', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),
                    titleBlock = post.find('.post-item-title'),
                    contentBlock = post.find('.post-item-content');

                listPost.removeClass('active');

                post.addClass('active');

                if (that.fieldComponent.checkExistField(post)) {

                }
            });
        };

        this.delete = function () {
            deleteBtn.on('click', function (e) {
                e.preventDefault();
            })
        };

        this.create = function () {

        };
    }

    function FieldComponent() {

        this.checkExistField = function (post) {
            var titleField = post.find('.title-post-input'),
                contentField = post.find('.content-post-input'),
                updateBtn = post.find('.update-post-btn');

            return (titleField.length && contentField.length && updateBtn.length) ? true : false;
        };

        this.createEditFieldPost = function (post) {
            var titleBlock = post.find('.post-item-title'),
                contentField = post.find('.content-post-input'),
                updateBtn = post.find('.update-post-btn');


        }
    }

    /**
     * Request
     *
     * @constructor
     */
    function Request() {

        this.__proto__ = settings;

        this.sendRequest = function (route, data = null, method) {

            var that = this;

            that.setRoute(route);

            $.ajax({
                url: that.getPath(),
                type: method,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-AUTH_TOKEN', that.token)
                },
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