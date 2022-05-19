<?php
namespace App\Database;

class DB {

  private $table;
  private $db;
  public function __construct($table)
  {
    $this->table = $table;
    $this->db = PDO_CONNECTION->db;
  }

  public static function table($table){
    return new DB($table);
  }

  public function select(string $selector, array $params = []){
    try {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$selector}");
        $stmt->execute($params);
        if(isset($this->classname)){
          $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->classname);
        } else $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;

    } catch(\PDOException $e) {
        die(new \PDOException($e->getMessage(), (int)$e->getCode()));
    }
  }

  public static function query(string $query, array $params = [], $fetch_class = ""){
    try {

        $stmt = PDO_CONNECTION->db->prepare($query);
        $stmt->execute($params);
        if($fetch_class !== ""){
          $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $fetch_class);
        } else $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;

    } catch(\PDOException $e) {
        die(new \PDOException($e->getMessage(), (int)$e->getCode()));
    }
  }
}