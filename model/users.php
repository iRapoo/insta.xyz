<?php

class users extends Atom
{
    public $id;
    public $login = "VARCHAR(255)";
    public $password = "VARCHAR(255)";
    public $rank = "VARCHAR(1) DEFAULT 'u'";
    public $access_key = "VARCHAR(128)";
}