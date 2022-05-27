<?php

namespace App\Models;
use App\Core\Model;

class Example extends Model {
    protected static $table = "example_table_name";
    // Just set the name of each SQL table column and accessors will automatically be generated
    protected $example;
}