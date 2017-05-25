;(function ($, undefined) {

    var settings = {
        host: 'localhost',
        pathDir: '/',
        route: 'index',

        token: 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0='
    };

    var template = {
        postContent: '<div><input type="text" class="form-control post-content-field" placeholder="Content"></div>',
        postTitle: '<div><input type="text" class="form-control post-title-field" placeholder="Title"></div>',
        postUpdateBtn: '<div><a href="" class="btn btn-primary update-post-btn">Update</a></div>'
    };

    function Event() {

        var that = this,
            container = $('.post-container'),
            postList = container.find('.post-item'),
            createBtn = container.find('.create-post-btn');

        this.init = function () {
            this.update();
            this.create();
            this.delete();
        };

        this.update = function () {
            postList.on('click', '.edit-post-btn', function (e) {
               e.preventDefault();

               var $this = $(this),
                   post = $this.parents('.post-item'),
                   postId = post.attr('id');

               postList.removeClass('active');

               $.each(postList, function () {
                   var post = $(this);
                    that.deleteUpdateField(post);
               });

               if (!that.checkUpdateField(post)) {
                   that.buildUpdateField(post);
               }
            });
        };

        this.create = function () {
            createBtn.on('click', function (e) {
                e.preventDefault();

                console.log('create');
            });
        };

        this.delete = function () {
            postList.on('click', '.delete-post-btn', function (e) {
                e.preventDefault();

                console.log('delete');
            })
        }
    }

    function Request() {

        this.__proto__ = settings;

        this.getRoute = function () {
            return window.location.href;
        };

        this.setRoute = function (route) {
            this.route = route;
        };

        this.getPath = function () {
            return 'http://' + this.host + '/' + this.route;
        };

        this.sendRequest = function (route, method, data = null) {

            var that = this;

            that.setRoute(route);

            $.ajax({
                url: that.getPath(),
                method: method,
                data: data,
                beforeSend: function(xhr){xhr.setRequestHeader('X-AUTH_TOKEN', 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0=')},
                success: function (data) {

                }
            });
        };
    }

    function FormEditor() {

        this.__proto__ = template;

        this.checkUpdateField = function (post) {
            var title = post.find('.post-title-field'),
                content = post.find('.post-content-field'),
                updateBtn = post.find('.update-post-btn');

            return (title.length && content.length && updateBtn.length) ? true :false;
        };

        this.deleteUpdateField = function (post) {
            post.find('.post-title-field').remove();
            post.find('.post-content-field').remove();
            post.find('.update-post-btn').remove();
        };

        this.buildUpdateField = function (post) {
            var titleContainer = post.find('.post-item-title'),
                containerContainer = post.find('.post-item-content'),
                postManageList = post.find('.post-manage-list');

            titleContainer.append(this.postTitle);
            containerContainer.append(this.postContent);
            postManageList.append(this.postUpdateBtn);
        }
    }

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