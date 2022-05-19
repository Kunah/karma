<?php
namespace App\Database;
use Exception;

class Initializer {

  public function __construct()
  {
    try {
      $this->db = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
      $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch(\PDOException $e) {
      switch($e->getCode()) {
        case 1049 :
          die(new Exception("Database ". DATABASE . " was not found"));
          break;
        case 2002 : 
          die(new Exception("SQL Server isn't started"));
        default : die(new \PDOException($e->getMessage(), (int)$e->getCode()));
      }
    }
  }

}