<?php 

  class DB {

    protected $mysqli;

    public function _construct(){
      $this->mysqli = new mysqli();
    } // _construct

    public function query($sql) {
      return $this->mysqli->query($sql);
    } // query

  } // DB

 ?>