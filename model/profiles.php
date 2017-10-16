<?php

class profiles extends Atom
{
    public $id;
    public $name = "VARCHAR(255)";
    public $photo = "VARCHAR(255)";
    public $status = "INT(1) DEFAULT 0";
}