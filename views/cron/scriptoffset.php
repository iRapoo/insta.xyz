<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("nosorted");

// Отвечаем только на Ajax
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

// Можно передавать в скрипт разный action и в соответствии с ним выполнять разные действия.
$action = $_POST['action'];
if (empty($action)) {return;}

$count = $_POST['count'];
$step = 1;

// Получаем от клиента номер итерации
$url = $_POST['name']; if (empty($url)) return;
$uid = $_POST['uid'];

$offset = ($_POST['offset'] == "-1" AND
            !empty($_COOKIE['_offset'.$uid]))
    ? ($_COOKIE['_offset'.$uid]+1) : $_POST['offset'];


// Проверяем, все ли строки обработаны
$offset = $offset + $step;
$correct = $_POST['correct'];
$incorrect = $_POST['incorrect'];
if ($offset >= $count) {
    setcookie("_offset".$uid, "", time() - 3600, "/");
    $success = 1;
} else {

    $medias = json_decode($_POST['medias']);
    $res = insertData($uid, $medias, $offset, $count);
    $success = $res['success'];

    if($res['status']==1){
        $correct++;
    }
    else{
        $incorrect++;
    }

    sleep(0.3);

}

// И возвращаем клиенту данные (номер итерации и сообщение об окончании работы скрипта)
$output = Array('offset' => $offset, 'success' => $success, 'correct' => $correct, 'incorrect' => $incorrect);
echo json_encode($output);

function insertData($uid, $medias, $offset, $count){

    $res = array();

    $nosorted = new nosorted();
    $nosorted->uid = $uid;
    $nosorted->type = $medias[$offset]->type;
    if(is_null($medias[$offset]->imageHighResolutionUrl)
        OR strlen($medias[$offset]->imageHighResolutionUrl) < 10
        OR $medias[$offset]->type!="image") {
            $nosorted->imageHighResolutionUrl = "404";
            $nosorted->active = 0;
            $status = 0;
    }
    else {
        $nosorted->imageHighResolutionUrl = downloadFile($medias[$offset]->imageHighResolutionUrl);
        $nosorted->active = 1;
        $status = 1;
    }
    $nosorted->datetime = date("Y:m:d");

    $nosorted->insert();

    setcookie("_offset".$uid, $offset, time() + 18000, "/");

    $res['success'] = round($offset / $count, 2);
    $res['status'] = $status;

    return $res;
}

function downloadFile ($URL) {
    $uploaddir = PATH."/views/cron/nosorted/";
    $uploadfile = $uploaddir.basename($URL);

    // Копируем файл в files
    if (copy($URL, $uploadfile)) {
        return basename($URL);
    } else {
        return false;
    }
}