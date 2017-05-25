;(function ($, undefined) {
    var app = {

        init: function () {
            this.sendData();
        },

        sendData: function () {
            $.ajax({
                url: 'http://dcodeit.net/kostya.nagula/project/restProject/index',
                method: 'POST',
                data: {
                    order: 'title',
                    orderParam: 'ASC'
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }
    };

    app.init();

})(jQuery);