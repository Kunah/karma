<?php

namespace App\Models;
use App\Core\Model;

class Example extends Model {
    private static $table = "example_table_name";
    // Array structured like this : $column (must be same in 2 tables) => $other_table
    private static $joins = ["example_column" => "another_table"] ;
    // Just set the name of each SQL table column and accessors will automatically be generated
    protected $example;
}