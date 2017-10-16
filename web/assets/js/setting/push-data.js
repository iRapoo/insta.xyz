$(function() {

    $('.btn-push').click(function() {

        var _input = $(this).parent().siblings("input");
        var _data_push = $(this).attr("data-push");

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/"+_data_push+".php",
            data: { "data" :  _input.val() },
            dataType: "text",
            success: function(data) {
                $('#myModal').modal('show');

                if(data)
                {
                    $('.modal-body').html("<p>Успешно добавлено!</p>");
                }
                else
                {
                    $('.modal-body').html("<p>Ошибка, попробуйте еще раз...<br>Возможно вы не указали данные</p>");
                }
            }
        });

    });

});