$(function() {

    $('.btn-edit').click(function() {

        var _data_id = $(this).attr("data-id");
        var _caption_cont = $('.caption_content[data-id="'+_data_id+'"]').html();

        $('#myModal').modal('show');
        $('.modal-title').html('Редактирование');
        $('.modal-footer').show();

        $('.modal-body').html("<textarea class=\"form-control\" rows=\"12\" data-id="+_data_id+">"+_caption_cont+"</textarea>");

        $('.btn-save-edit').attr({ 'data-id' : _data_id });

    });

    $('.btn-save-edit').click(function() {

        var _data_id = $(this).attr("data-id");
        var _caption_cont = $('textarea[data-id="'+_data_id+'"]').val();

        $('.modal-title').html('Результат');
        $('.modal-footer').hide();

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/_update.php",
            data: { "data-id" :  _data_id, "data-caption" : _caption_cont },
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

        $('.modal-title').html('Результат');
        $('.modal-footer').hide();

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