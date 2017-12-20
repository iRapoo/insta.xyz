<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
require_once PATH.'/core/kernel.php';

Atom::setup($_config->_getMySQLi());
Atom::model("subsections");

foreach (subsections::findByTag("cid", $_POST['data'], "ORDER BY `id`") as $sub){
    if(!empty($sub->name)) {
        $res .= '<option value="'.$sub->id.'">'.$sub->name.'</option>';
    }
}

echo $res;