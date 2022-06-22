<?php
namespace App\Core\Database;

/*---------- Initializer Class ----------*/
// This class only handle PDO Connection
// If you need to implement a new SQL query method,
// check App\Core\Database\DB Class instead
class Initializer {

  /*---------- Creating PDO Connection ----------*/
  // To change your PDO Connection params, check config/config.php file, don't touch it
  public function __construct()
  {
    $this->db = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }
  
}