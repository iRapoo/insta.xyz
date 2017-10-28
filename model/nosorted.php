<?php

class nosorted extends Atom
{
    public $id;
    public $uid = "INT(11)";
    public $imageHighResolutionUrl = "VARCHAR(255)";
    public $link = "VARCHAR(255)";
    public $type = "VARCHAR(255)";
    public $caption = "LONGBLOB";
    public $datetime = "DATE";
    public $active = "INT(1) DEFAULT 0";
}