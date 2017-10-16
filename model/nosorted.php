<?php

class nosorted extends Atom
{
    public $id;
    public $uid = "INT(11)";
    public $imageHighResolutionUrl = "VARCHAR(255)";
    public $type = "VARCHAR(255)";
    public $active = "INT(1) DEFAULT 0";
    public $datetime = "DATE";
}