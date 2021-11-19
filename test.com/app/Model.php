<?php

namespace app;
include 'Db.php';

abstract class Model
{
    public $db;

    public function __construct(){
        $this->db = new Db;
    }
}