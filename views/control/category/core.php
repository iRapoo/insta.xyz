<?php

if(!empty($_GET['id']))
    $page_name = category::findById($_GET['id'])->name;
else
    $page_name = "Все разделы";