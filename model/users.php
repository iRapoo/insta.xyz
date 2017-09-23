<?php

class users extends Atom
{
    public $id;
    public $login = "VARCHAR(255)";
    public $birthday = "DATE";
    public $email = "VARCHAR(255)";
    public $password = "VARCHAR(255)";
    public $phone = "VARCHAR(255)";
    public $sex = "VARCHAR(6)";
    public $rank = "VARCHAR(1) DEFAULT 'u'";
    public $access_key = "VARCHAR(128)";
}