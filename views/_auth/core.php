<?php

if(isset($_POST['auth_exit'])){
    session_unset();
    session_destroy();

    if(isset($_COOKIE['_ak']))
        setcookie("_ak", "", time() - 3600, "/");

    if (@$_SERVER['HTTP_REFERER'] != null) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location: /control");
    }
    exit();
}

Atom::setup($_config->_getMySQLi());
Atom::model("users");

$login = $_POST['login'];
$password = $_POST['password'];

$need = [ "id", "login" ];
$_ak = $_COOKIE['_ak'];

$db_user = users::findByTag("login", $login, "OR `access_key` = '{$_ak}' ");

if(!empty($db_user)) {
    foreach ($db_user as $user) {
        if (!empty($user)) {
            $hashed_password = (!empty($user->password)) ? $user->password : "";
            if (hash_equals($hashed_password, crypt($password, $hashed_password)) OR (!empty($_ak))) {
                foreach ($need as $value) {
                    $_SESSION[$value] = $user->$value;
                }
                if ($_POST['remember']) {
                    setcookie("_ak", $user->access_key, time() + 2592000, "/");
                }
            }
        }
    }

    if (@$_SERVER['HTTP_REFERER'] != null) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location: /control");
    }
    exit();
}
else{
    $_config->body .= '<div class="alert alert-danger"><center><strong>Ошибка авторизации!</strong> Попробуйте еще раз или <a href="/" class="alert-link">вернитесь на главную страницу!</a></center></div>';
    $_config->body .= '<div class="alert alert-warning"><center>Возможно не верный логин или пароль!</a></center></div>';
}

