$(function() {

    $('.btn-del').click(function() {

        var _data_id = $(this).attr("data-id");
        var _data_del = $(this).attr("data-del");

        $.ajax({
            type: "POST",
            url: "/views/control/setting/delete/"+_data_del+".php",
            data: { "data" :  _data_id },
            dataType: "text",
            success: function(data) {
                $('#myModal').modal('show');

                if(data)
                {
                    $('.modal-body').html("<p>Успешно удалено!</p>");
                }
                else
                {
                    $('.modal-body').html("<p>Ошибка, попробуйте еще раз...</p>");
                }
            }
        });

    });

});