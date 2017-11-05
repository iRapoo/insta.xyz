<?php

Atom::setup($_config->_getMySQLi());
Atom::model("users");

$user = new users();
$_POST['access_key'] = Generate::genRandomString(false, 125, true);
foreach ($_POST as $key => $value) {

    if($key!="password")
        $user->$key = $value;
    else
        $user->$key = crypt($value);

}
$user->rank = "a";

if($user->insert())
    echo true;
else
    echo false;
