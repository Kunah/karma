<?php

namespace App\Core;
use App\Core\Database\DB;

/*---------- Model Class ----------*/
abstract class Model {

    /*---------- Only to prevent a bug ----------*/
    // Without this method, dynamic getters/setters
    // generation doesn't work, don't remove it if
    // you want to use this feature
    public function __call($name, $arguments)
    {
        return call_user_func($this->{$name}, $arguments);
    }

    /*---------- Get all getters and setters to generate ----------*/
    // This method create a reflection class, to get all protected props
    // of the class that called it, and generate getters and setters
    function getvars()
    {
        $reflection = new \ReflectionClass($this);
        return $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);
    }

    /*---------- Getters and Setters generating ----------*/
    public function __construct(){
        $reflector = new \ReflectionClass($this);
        $this->classname = str_replace("App\\Models\\", "", get_class($this));
        $props = $reflector->getStaticProperties();
        $this->db = new DB(isset($props['table']) ? $props['table'] : strtolower($this->classname));
        
        foreach ($this->getvars() as $arg){ // For each protected prop of the reflection class
            /*---------- Formats getter and setter names ----------*/
            $getter = "get".ucfirst($arg->getName());
            $setter = "set".ucfirst($arg->getName());
            /*---------- Getter method ----------*/
            $getMethod = (function() use ($arg){
                return $this->{$arg->getName()};
            });
            /*---------- Setter method ----------*/
            $setMethod = (function($param) use ($arg){
                $this->{$arg->getName()} = $param;
            });

            /*---------- Apply it to the classe's context ----------*/
            $this->{$getter} = $getMethod;
            $this->{$setter} = $setMethod;
        }

        /*---------- Dynamic joins generating ----------*/
        // This method generates joins dynamically
        if(isset($props['joins'])) {
            foreach ($props['joins'] as $column => $table) {
                $this->{$table} = (function() use ($table, $column) {
                    $className = "App\\Models\\".ucfirst($table);
                    return call_user_func_array([$className, "find"], ["$column = :$column", ["$column" => $this->{'get'.ucfirst($column)}()]])[0];
                });
            }
        }
    }

    /*---------- SQL Select * method ----------*/
    // This method doesn't take any param, if you want
    // to filter results, better use "find" method
    public static function all(){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = $_ENV['pdo']->db->query("SELECT * FROM {$table}");
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        $stmt->closeCursor();
        return $result;
    }

    /*---------- SQL Select method ----------*/
    // This method only executes prepared statements, but you can use but without any params
    // The selector param is what you want to put in your WHERE clause
    public static function find(string $selector, array $params = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = $_ENV['pdo']->db->prepare("SELECT * FROM {$table} WHERE {$selector}");
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        $stmt->closeCursor();
        return $result;
    }

    /*---------- SQL Delete method ----------*/
    // This method only executes prepared statements, but you can use but without any params
    // The selector param is what you want to put in your WHERE clause
    public static function delete(string $selector, array $params = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $stmt = $_ENV['pdo']->db->prepare("DELETE FROM {$table} WHERE {$selector}");
        $stmt->execute($params);
        $stmt->closeCursor();
        return "success";
    }

    /*---------- SQL Insert method ----------*/
    // Usage example: 
    // This :
    //      MyModel::create(["name" => "John", "age" => 29])
    // Will result :
    //      INSERT INTO mymodel (`name`, `age`) VALUES ("John", 29);
    public static function create(array $data = []){
        $class = get_called_class();
        $reflector = new \ReflectionClass($class);
        $props = $reflector->getStaticProperties();
        $table = isset($props['table']) ? $props['table'] : str_replace("App\\Models\\", "", $class);
        $cols = $_ENV['pdo']->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DATABASE."' AND TABLE_NAME='{$table}';")->fetchAll();
        $query = "INSERT INTO `{$table}` (";
        $values = "(";
        foreach($cols as $col){
            $query = $query."`{$col['COLUMN_NAME']}`,";
            $values = $values.(gettype($data[$col['COLUMN_NAME']]) == "string" ? "'{$data[$col['COLUMN_NAME']]}'" : $data[$col['COLUMN_NAME']]).',';
        }
        $query = rtrim($query, ',').") VALUES ".rtrim($values, ',').")";
        return $_ENV['pdo']->db->query($query);
    }

    /*---------- SQL Insert method ----------*/
    // Usage example: 
    // This :
    //      MyModel::update("id=1", ["name" => "John", "age" => 29])
    // Will result :
    //      UPDATE mymodel SET `name`="John", `age`=29 WHERE id=1;
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
        return $_ENV['pdo']->db->query($query);
    }

}
