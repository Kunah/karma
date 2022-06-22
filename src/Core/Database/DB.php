<?php
namespace App\Core\Database;

/*---------- DB Class ----------*/
// This class is not handling PDO Connection, DB class is the one that has premade SQL queries methods (select, query)
// To see PDO Connection handling, check App\Core\Database\Initializer Class

class DB {

  /*---------- Defining necessary variables (table name and db name) ----------*/
  private $table;
  private $db;
  public function __construct($table)
  {
    $this->table = $table;
    $this->db = $_ENV['pdo']->db;
  }

  /*---------- Table choosing method ----------*/
  // This method is there despite the presence of the __construct method that handles table choosing
  // to allow a static using of DB class, example :
  // Without this method, the only way use this class is : new DB("myTable")->select("myCondition");
  // With this method, you can do either it, or: DB::table("myTable")->select("myCondition");
  // The result is exactly same, but i have a preference for static methods, i think that :: are prettier than ->
  public static function table($table){
    return new DB($table);
  }

  /*---------- SQL Select method ----------*/
  // This method only executes prepared statements, but you can use but without any params
  // The selector param is what you want to put in your WHERE clause
  public function select(string $selector, array $params = []){
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$selector}");
    $stmt->execute($params);
    if(isset($this->classname)){
      $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->classname);
    } else $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
  }

  /*---------- SQL Query method ----------*/
  // This method only executes prepared statements, but you can use iut without any params
  // The difference with "select" method is that you have to give the entire query,
  // it is here to allow you creating the queries you want without having to bypass DB Class
  // For example, this case can happen with complex queries, with joins, or a method
  // the class doesn't provide (delete, insert, udpate...)
  //
  // !! WARNING
  // For the non provided method i cited above, better use a model (models provide all these methods)
  public static function query(string $query, array $params = [], $fetch_class = ""){
    $stmt = $_ENV['pdo']->db->prepare($query);
    $stmt->execute($params);
    if($fetch_class !== ""){
      $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $fetch_class);
    } else $result = $stmt->fetchAll();
    $stmt->closeCursor();
    return $result;
  }
}