$(function() {

    $('.btn-follow').click(function() {
        $('.newFollowForm')[0].reset();
        $('#newFollow').modal('show');
    });

    $('#newFollowForm').submit(function() {
        var form = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '/views/control/setting/push/follower.php',
            data: form,
            success: function(data) {
                if(data==true) {
                    $('#newFollow').modal('hide');
                    alert("Вы успешно подписались!");
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
            url: "/views/control/setting/push/follower_stat.php",
            data: { "data" :  _data_id, "data_stat": _data_stat },
            dataType: "text",
            success: function(data) { }
        });

    });

});