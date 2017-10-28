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

    $('.btn-send').click(function() {

        var _data_id = $(this).attr("data-id");
        var _data_img = $(this).closest(".img-parent").attr("data-img");

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/catalog.php",
            data: { "data" :  _data_id, "data-img" :  _data_img },
            dataType: "text",
            success: function(data) {
                $('#myModal').modal('show');

                if(data)
                {
                    $('.modal-body').html("<p>Успешно перенесено!</p>");
                }
                else
                {
                    $('.modal-body').html("<p>Ошибка, попробуйте еще раз...</p>");
                }
            }
        });

    });

    $('.btn-stat').click(function() {

        var _data_id = $(this).attr("data-id");
        var _data_stat = $(this).attr("data-stat");

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/profiles_stat.php",
            data: { "data" :  _data_id, "data_stat": _data_stat },
            dataType: "text",
            success: function(data) {
                $('#myModal').modal('show');

                if(data)
                {
                    $('.modal-body').html("<p>Успешно обновлено!</p>");
                }
                else
                {
                    $('.modal-body').html("<p>Ошибка, попробуйте еще раз...</p>");
                }
            }
        });

    });

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

    $('.btn-add-sub').click(function() {

        var _data_id = $(this).attr("data-id");

        var sub = prompt("Укажите название подраздела");

        if(sub!=null && sub.length > 0){

            $.ajax({
                type: "POST",
                url: "/views/control/setting/push/category_add_sub.php",
                data: { "data" :  _data_id, "data_name" : sub },
                dataType: "text",
                success: function(data) {
                    $('#myModal').modal('show');

                    if(data)
                    {
                        $('.modal-body').html("<p>Успешно добавлено!</p>");
                    }
                    else
                    {
                        $('.modal-body').html("<p>Ошибка, попробуйте еще раз...</p>");
                    }
                }
            });

        }

    });

});