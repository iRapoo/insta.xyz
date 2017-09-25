<?php

use InstagramScraper\Instagram;

$user = (!$_GET['user']) ? "kevin" : $_GET['user'];

$_config->title = "Инстаграм ".$user;

$medias = Instagram::getMedias($user, 150);

foreach ($medias as $item)
    $_config->body .= '<img width="50px" src="'.$item->imageHighResolutionUrl.'">';
