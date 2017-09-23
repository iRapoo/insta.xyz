<?php

Atom::setup($_config->_getMySQLi());
Atom::model("users");

$_config->title = "Регистрация";

$_config->css[] = _ASSETS_."/css/reg.css";
$_config->js[] = _ASSETS_."/js/bootstrap-libs/bootstrap-formhelpers-phone.js";
$_config->js[] = _ASSETS_."/js/_regValid.js";

$access = (empty($_POST)) ? true : false;

switch($_GET['status']){
    case "ok":
        $success = "<font color='#006400'>Регистрация прошла успешно!</font>";
        break;
    case "error":
        $success = "<font color='#8b0000'>Ошибка регистрации, повторите позже...</font>";
        break;
}

if(!$access) {
    $user = new users();
    $_POST['access_key'] = Generate::genRandomString(false, 125);
    foreach ($_POST as $key => $value) {

        if($key!="password")
            $user->$key = $value;
        else
            $user->$key = crypt($value);

    }
    $user->rank = "u";
    if($user->insert())
        header("location: ".$_SERVER['REQUEST_URI']."?status=ok");
    else
        header("location: ".$_SERVER['REQUEST_URI']."?status=error");
}

$html = new Kernel();
$html->_setHtml(_DIR_._VIEW_."/reg.tpl.html");
$html->_setIf("post", (empty($_GET['status'])));
$html->_setVar("result_registration", $success);
$_config->body .= $html->_getHtml();