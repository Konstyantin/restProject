;(function ($, undefined) {

    var settings = {
        host: 'dcodeit.net',
        pathDir: '/kostya.nagula/project/restProject/',
        route: 'index',

        token: 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0='
    };

    var template = {
        postContent: '<div><input type="text" class="form-control post-content-field" placeholder="Content"></div>',
        postTitle: '<div><input type="text" class="form-control post-title-field" placeholder="Title"></div>',
        postUpdateBtn: '<div><a href="" class="btn btn-primary update-post-btn">Update</a></div>',
        postCreateForm: '<div class="add-post-form clearfix"><div class="col-lg-3 post-form-field"><input type="text" class="form-control create-post-title-field" placeholder="Title"></div><div class="col-lg-3 post-form-field"><input type="text" class="form-control create-post-content-field" placeholder="Content"></div><a href="" class="btn btn-success create-post-btn">Create</a></div>'
    };

    function Event() {

        this.request = new Request();

        var that = this,
            container = $('.post-container'),
            postList = container.find('.post-item'),
            createBtn = container.find('.add-post-btn');

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
                    postId = post.attr('id'),
                    route = 'post/' + postId;

                postList.removeClass('active');

                $.each(postList, function () {
                    var post = $(this);
                    that.deleteUpdateField(post);
                });

                if (!that.checkUpdateField(post)) {
                    post.addClass('active');
                    that.buildUpdateField(post);
                }

                postList.on('click', '.update-post-btn', function (e) {
                    e.preventDefault();

                    var data = that.getFormData(post);

                    data = JSON.stringify(data);

                    that.request.sendRequest(route, 'PUT', data);
                });
            });
        };

        this.create = function () {
            createBtn.on('click', function (e) {
                e.preventDefault();

                var addPostContainer = $('.add-post-container');

                that.addPostForm(addPostContainer);

                container.on('click', '.create-post-btn', function (e) {
                    e.preventDefault();

                    var title = container.find('.create-post-title-field').val(),
                        content = container.find('.create-post-content-field').val();

                    var data = {
                        'title': title,
                        'content': content
                    };

                    data = JSON.stringify(data);

                    that.request.sendRequest('post', 'POST', data);
                });
            });
        };

        this.delete = function () {
            postList.on('click', '.delete-post-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    post = $this.parents('.post-item'),
                    postId = post.attr('id'),
                    route = 'post/' + postId;

                that.request.sendRequest(route, 'DELETE');

                post.remove();
            });
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
            return 'http://' + this.host + this.pathDir + this.route;
        };

        this.sendRequest = function (route, method, data = null) {

            var that = this;

            that.setRoute(route);

            $.ajax({
                url: that.getPath(),
                method: method,
                contentType: 'application/json',
                dataType: 'json',
                data: data,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-AUTH_TOKEN', 'eyJpZCI6MSwidGltZSI6MTQ5MDI3MDg5Mn0=')
                },
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

            return (title.length && content.length && updateBtn.length) ? true : false;
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
        };

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

        this.addPostForm = function (container) {
            var child = container.children();

            if (!child.length) {
                container.append(this.postCreateForm);
            }
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