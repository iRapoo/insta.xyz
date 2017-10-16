var _c1 = 0;

$(document).ready(function() {
    _c1 = $('c').html();
    onStart(0);
});

function showProcess (name, success, offset, correct, incorrect, action, count, medias, uid, _c) {
    $('div.form').eq(_c).find('#name, #refreshScript').hide();
    $('div.form').eq(_c).find('.progress').show();
    $('div.form').eq(_c).find('.bar').text(name + ": " + (success * 100).toFixed() + '%');
    $('div.form').eq(_c).find('.bar').css('width', success * 100 + '%');
    $('div.form').eq(_c).find('.status span').eq(0).text("Заугружено: "+correct);
    $('div.form').eq(_c).find('.status span').eq(1).text("Исключено: "+incorrect);
    $('div.form').eq(_c).find('.status span').eq(2).text("Обработано: "+(offset+1));

    scriptOffset(name, offset, correct, incorrect, action, count, medias, uid, _c);
}

function getMedias (name, offset, correct, incorrect, action, count, uid, _c) {
    $('div.form').eq(_c).find('#name, #refreshScript').hide();
    $('div.form').eq(_c).find('.progress').show();
    $('div.form').eq(_c).find('#runScript').hide();
    $('div.form').eq(_c).find('.bar').text('Подготовка к загрузке');
    $('div.form').eq(_c).find('.bar').css('width', 100 + '%');

    $.ajax({
        url: "/views/cron/getMedias.php",
        type: "POST",
        data: {
            "name":name,
            "count":count
        },
        success: function(data){
            scriptOffset(name, offset, correct, incorrect, action, count, data, uid, _c);
        }
    });
}

function scriptOffset (name, offset, correct, incorrect, action, count, medias, uid, _c) {
    $.ajax({
        url: "/views/cron/scriptoffset.php",
        type: "POST",
        data: {
            "action":action,
            "name":name,
            "offset":offset,
            "correct":correct,
            "incorrect":incorrect,
            "count":count,
            "medias":medias,
            "uid":uid
        },
        success: function(data){
            data = $.parseJSON(data);
            if(data.success < 1) {
                showProcess(name, data.success, data.offset, data.correct, data.incorrect, action, count, medias, uid, _c);
            } else {
                $('div.form').eq(_c).find('.bar').css('width','100%');
                $('div.form').eq(_c).find('.bar').text(name+' - - - OK');

                if(_c<(_c1-1)) onStart(_c+1);
            }
        }
    });
}

function onStart(i) {

    var count = $('div.form').eq(i).find('#count').val();
    var uid = $('div.form').eq(i).find('#uid').val();
    var action = $('div.form').eq(i).find('#runScript').data('action');
    var name = $('div.form').eq(i).find('#name').val();

    getMedias(name, -1, 0, 0, action, count, uid, i);
}