<?php

Atom::setup($_config->_getMySQLi());
Atom::model("users");

$object = new Kernel();
$object->_setHtml(_DIR_._VIEW_."/atom.tpl.html");
$object->_setVar("first_user", users::findById(1)->login);
$object->_setVar("second_user", users::findById(2)->login);
$BODY .= $object->_getHtml();

foreach (users::findAll("ORDER BY `id` DESC") as $user){
    if(!empty($user))
        echo $user->id.". ".$user->login."<br>";
}

foreach (users::findByTag("login", "Rapoo") as $user) {
    if(!empty($user))
        echo $user->id.". ".$user->login."<br>";
}

$names = [ "first", "second", "thirsd" ];

$name = new users();

for($i=0;$i<count($names);$i++){
    $name->login = $names[$i];
    //$name->insert();
}

$user_del = new users();

$user_del->login = "first";

$user_del->delete();


print_r(users::findAll());


