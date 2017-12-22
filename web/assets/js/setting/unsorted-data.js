$(function() {

    $('.btn-accept').click(function() {

        var _data_get = $(this).attr("data-get")

        $.ajax({
            type: 'POST',
            url: '/views/control/unsorted/get.php',
            data: { "data" :  _data_get },
            success: function(data) {
                if(data!=false) {

                    var arr = JSON.parse(data);

                    $('.item_image img').attr({ "src" : arr.image });
                    $('.caption_panel').html(arr.caption);
                    $('.data-id-image').val(arr.id);
                    $('.btn-del-item').attr({ 'data-id' : arr.id });


                }else alert("Ошибка, возможно такой страницы не существует!");
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });

        $('#editModal').modal('show');

    });

    $('.btn-next').click(function() {
        var _data_get = $(this).val();
        nextAccept(_data_get);
    });

    $(".select-category").change(function(){

        if($(this).val() == 0) return false;

        $.ajax({
            type: 'POST',
            url: '/views/control/unsorted/get_sub.php',
            data: { "data" :  $(this).val() },
            success: function(data) {
                if(data!=false) {
                    $('.select-sub').html("<option disabled selected>Выбрать подраздел</option>" + data);
                }else alert("Ошибка, возможно такой страницы не существует!");
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
    });

    $('#editModalForm').submit(function() {

        var _data_form = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/views/control/setting/push/catalog_accept.php",
            data: _data_form,
            success: function(data) {
                if(data)
                {
                    nextAccept($('.data-id-image').val());
                }
                else
                {
                    alert("Ошибка, возможно не все параметры указаны!");
                }
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });

        return false;
    });

    $('.btn-cancel').click(function() {
        location.reload();
    });

    $('.btn-del-item').click(function() {

        var _data_id = $(this).attr("data-id");

        var _isDel = confirm("Вы действительно хотите удалить запись?");

        if(_isDel) {
            $.ajax({
                type: "POST",
                url: "/views/control/setting/delete/nosorted.php",
                data: {"data": _data_id},
                dataType: "text",
                success: function (data) {
                    if (data) {
                        alert("Успешно удалено!");
                        nextAccept(_data_id);
                    }
                    else {
                        alert("Ошибка, попробуйте еще раз...");
                    }
                }
            });
        }

    });

    function nextAccept(_data_get) {
        $.ajax({
            type: 'POST',
            url: '/views/control/unsorted/get_next.php',
            data: { "data" :  _data_get },
            success: function(data) {
                if(data!=false) {

                    var arr = JSON.parse(data);

                    $('.item_image img').attr({ "src" : arr.image });
                    $('.caption_panel').html(arr.caption);
                    $('.data-id-image').val(arr.id);
                    $('.btn-del-item').attr({ 'data-id' : arr.id });

                }else alert("Ошибка, возможно такой страницы не существует!");
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });

        $('#editModal').modal('show');
    }

});