<?php

$file = 'page.txt';
$current = file_get_contents($file);

file_put_contents($file, $_POST['content']);

echo 'Done';