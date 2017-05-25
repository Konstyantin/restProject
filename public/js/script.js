;(function ($, undefined) {
    var app = {

        init: function () {
            this.sendData();
        },

        sendData: function () {
            $.ajax({
                url: 'http://localhost/index',
                method: 'POST',
                data: {name: 'test'},
                success: function (data) {
                    console.log(data);
                }
            });
        }
    };

    app.init();

})(jQuery);