<?php

  class DB {

    protected $mysqli;

    public function __construct(){
      $this->mysqli = new mysqli('dbhost.cs.man.ac.uk', 'mbaxarm3', '160190pi', 'mbaxarm3'); 
                                  
    } // _construct

    public function query($sql) {
      return $this->mysqli->query($sql);
    } // query

  } // DB

 ?>
