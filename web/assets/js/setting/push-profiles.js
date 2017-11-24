$(function() {

    $('.new-profile').click(function() {
        $('.newProfileForm')[0].reset();
        $('#newProfile').modal('show');
    });

    $('#newProfileForm').submit(function() {
        var form = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '/views/control/setting/push/profiles.php',
            data: form,
            success: function(data) {
                if(data==true) {
                    $('#newProfile').modal('hide');
                    location.reload();
                }else alert("Ошибка, возможно такой страницы не существует!");
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });

        return false;
    });

    $('.slider').click(function() {

        var _data_id = $(this).attr("data-id");
        var _data_stat = $(this).siblings('input').is(':checked');

        _data_stat = (_data_stat) ? "0" : "1";

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/profiles_stat.php",
            data: { "data" :  _data_id, "data_stat": _data_stat },
            dataType: "text",
            success: function(data) { }
        });

    });

    $('._delete').click(function() {

        var _data_id = $(this).attr("data-id");

        var isDel = confirm("Вы уверены что хотите удалить?");

        if(isDel) {
            $.ajax({
                type: "POST",
                url: "/views/control/setting/delete/profiles.php",
                data: {"data": _data_id},
                dataType: "text",
                success: function (data) {
                    if(data){
                        $('tr[data-id='+_data_id+']').animate({"opacity" : "0.3"}, 300);
                    }else alert("Ошибка удаления!");
                }
            });
        }

    });

});