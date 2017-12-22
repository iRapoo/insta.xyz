$(function (){

    ClassicEditor.create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        });

    $('.btn-save-ckedit').click(function () {
            var _ck_edit_text = $('.ck-editor__editable').html();
            updateFile(_ck_edit_text, location.href.split("/")[3]);
    } );

    function updateFile(obj, page)
    {
        $.ajax({
            url: "/views/"+page+"/edit.php",
            type: "POST",
            data: {
                "content":obj
            },
            success: function(data){
                alert("Страница сохранена успешно!");
            }
        });
    }

});

