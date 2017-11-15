<?php

class profiles extends Atom
{
    public $id;
    public $name = "VARCHAR(255)";
    public $photo = "VARCHAR(255)";
    public $city = "VARCHAR(255)";
    public $contact = "TEXT";
    public $email = "VARCHAR(255)";
    public $phone = "VARCHAR(255)";
    public $date = "DATE";
    public $status = "INT(1) DEFAULT 0";
}