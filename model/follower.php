<?php

class follower extends Atom
{
    public $id;
    public $email = "VARCHAR(255)";
    public $active = "INT(1) DEFAULT 1";
}