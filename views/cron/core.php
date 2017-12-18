<?php

use InstagramScraper\Instagram;

Atom::setup($_config->_getMySQLi());
Atom::model("profiles");
Atom::model("nosorted");

$accessKey = "u23is91k";

if($_GET['key']!=$accessKey) exit("Код доступа не совпадает");

$profiles = profiles::findAll("WHERE `status` = 1");

$now = date("y-m-d");
$deteTime = date("Y.m.d H:i");

$file = _DIR_._VIEW_.'/log.txt';
$current = file_get_contents($file);
$current .= "----------------".$deteTime."------------------\n";

set_time_limit(3600);

$j = 0;
if(!empty($profiles))
{
    foreach ($profiles as $item)
    {
        if(!empty($item->id))
        {

            $SQLi = $_config->_getMySQLi()->query("SELECT * FROM `nosorted` WHERE `uid` = '{$item->id}'");
            $count = mysqli_num_rows($SQLi);

            $date = new DateTime('-15 days');
            $now = ($count>0) ? $now : $date->format('y-m-d');

            $instagram = new Instagram();
            $medias = $instagram->getMedias($item->name, 500, $now);

            //print_r($medias);

            $i = 0;
            foreach ($medias as $media){
                $res = insertData($item->id, $medias, $i);
                $i++;
            }

            $current .= $item->name." [".$i."]\n";
            echo $item->name." [".$i."]<br>";

            sleep(0.3);

            $j += $i;

        }
    }
}

$current .= "Всего: ".$j."\n";

file_put_contents($file, $current);

function insertData($uid, $medias, $offset){
    $nosorted = new nosorted();
    $nosorted->uid = $uid;
    $nosorted->type = $medias[$offset]->getType();

    $nosorted->link = $medias[$offset]->getLink();


    $file = downloadFile($medias[$offset]->getImageHighResolutionUrl());

    $nosorted->imageHighResolutionUrl = $file;
    $nosorted->active = (!$file) ? 0 : 1;

    $nosorted->caption = $medias[$offset]->getCaption();
    $nosorted->datetime = date('y-m-d', $medias[$offset]->getCreatedTime());

    return $nosorted->insert();
}

function downloadFile ($URL) {
    $uploaddir = PATH."/data/unsorted/";
    $uploadfile = $uploaddir.basename($URL);

    // Копируем файл в files
    if (@fopen($URL, "r") AND strlen($URL) > 10) {
        if (copy($URL, $uploadfile)) {
            return basename($URL);
        } else {
            return false;
        }
    }else {
        return false;
    }
}
