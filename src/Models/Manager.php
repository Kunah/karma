<?php


namespace App\Models;


class Manager
{

    public function __construct(){
        $this->classname = str_replace("Manager", "", str_replace("App\\Models\\", "", get_class($this)));
        try {
            $this->db = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die(new PDOException($e->getMessage(), (int)$e->getCode()));
        }
    }

    public function query(string $query, array $params = []){
        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(\PDO::FETCH_CLASS, "App\Models\{$this->classname}");
            $stmt->closeCursor();
            return $result;

        } catch(PDOException $e) {
            die(new PDOException($e->getMessage(), (int)$e->getCode()));
        }
    }
}