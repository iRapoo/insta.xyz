<?php

use InstagramScraper\Instagram;

$user = (!$_GET['user']) ? "kevin" : $_GET['user'];

$medias = Instagram::getMedias($user, 450);
$account = Instagram::getAccount($user);

$_config->title = "Инстаграм ".$account->fullName;

foreach ($medias as $item)
    $_config->body .= '<img width="50px" src="'.$item->imageHighResolutionUrl.'">';
