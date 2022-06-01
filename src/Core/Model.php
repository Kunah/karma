<?php

namespace App\Core;
use App\Core\Database\DB;

class Model {

    public function __call($name, $arguments)
    {
        return call_user_func($this->{$name}, $arguments);
    }

    function getvars()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
    }

    public function __construct(){
        $reflector = new \ReflectionClass($this);
        $this->classname = str_replace("App\\Models\\", "", get_class($this));
        $props = $reflector->getStaticProperties();
        $this->db = new DB(isset($props['table']) ? $props['table'] : strtolower($this->classname));
        foreach ($this->getvars() as $arg){
            $getter = "get".ucfirst($arg->getName());
            $setter = "set".ucfirst($arg->getName());
            $getMethod = (function() use ($arg){
                return $this->{$arg->getName()};
            });
            $setMethod = (function($param) use ($arg){
                $this->{$arg->getName()} = $param;
            });

            $this->{$getter} = $getMethod;
            $this->{$setter} = $setMethod;
        }
        if(isset($props['joins'])) {
            foreach ($props['joins'] as $column => $table) {
                $this->{$table} = (function() use ($table, $column) {
                    $className = "App\\Models\\".ucfirst($table);
                    return call_user_func_array([$className, "find"], ["$column = :$column", ["$column" => $this->{'get'.ucfirst($column)}()]])[0];
                });
            }
        }
    }

    public static function all(){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = PDO_CONNECTION->db->query("SELECT * FROM {$table}");
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        $stmt->closeCursor();
        return $result;
    }

    public static function find(string $selector, array $params = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = PDO_CONNECTION->db->prepare("SELECT * FROM {$table} WHERE {$selector}");
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        $stmt->closeCursor();
        return $result;
    }

    public static function delete(string $selector, array $params = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = PDO_CONNECTION->db->prepare("DELETE FROM {$table} WHERE {$selector}");
        $stmt->execute($params);
        $stmt->closeCursor();
        return "success";
    }

    public static function create(array $data = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $cols = PDO_CONNECTION->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME='{$table}';")->fetchAll();
        $query = "INSERT INTO `{$table}` (";
        $values = "(";
        foreach($cols as $col){
            $query = $query."`{$col['COLUMN_NAME']}`,";
            $values = $values.(gettype($data[$col['COLUMN_NAME']]) == "string" ? "'{$data[$col['COLUMN_NAME']]}'" : $data[$col['COLUMN_NAME']]).',';
        }
        $query = rtrim($query, ',').") VALUES ".rtrim($values, ',').")";
        return PDO_CONNECTION->db->query($query);
    }

    public static function update(string $selector, array $data = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $query = "UPDATE `{$table}` SET ";
        foreach($data as $k=>$v){
            $query = $query."`{$k}` = ".(gettype($v) == "string" ? "'{$v}'" : $v).",";
        }
        $query = rtrim($query, ',');
        $query = $query." WHERE {$selector}";
        return PDO_CONNECTION->db->query($query);
    }

}
