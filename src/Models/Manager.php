<?php

namespace App\Models;

use Exception;

class Manager
{
    public function __construct(){
        $this->classname = str_replace("Manager", "", str_replace("App\\Models\\", "", get_class($this)));
        try {
            $this->db = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            switch($e->getCode()) {
                case 1049 :
                    $this->db = new \PDO('mysql:host='.HOST.';charset=utf8;' , USER, PASSWORD);
                    $this->db->query('CREATE DATABASE '.DATABASE.';');
                    $this->db->query('USE '.DATABASE.';');
                    echo "Database ". DATABASE . " was not found and has been created";
                    break;
                case 2002 : 
                    die(new Exception("SQL Server isn't started"));
                default : die(new \PDOException($e->getMessage(), (int)$e->getCode()));
            }
        }
    }

    public function query(string $query, array $params = []){
        try {

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(\PDO::FETCH_CLASS, "App\\Models\\{$this->classname}");
            $stmt->closeCursor();
            return $result;

        } catch(\PDOException $e) {
            die(new \PDOException($e->getMessage(), (int)$e->getCode()));
        }
    }
}