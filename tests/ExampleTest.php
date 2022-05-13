<?php

// Run this command to start your tests : 
// vendor\bin\phpunit ./tests 
namespace Tests;

use PHPUnit\Framework\TestCase;

include 'src/config/config.php';

final class ExampleTest extends TestCase {
    public function testExampleSuccess(){
        $manager = new \App\Models\ExampleManager();
        $this->assertEquals($manager->getData(), 'success_test');
    }

    public function testExampleError(){
        $manager = new \App\Models\ExampleManager();
        $this->assertEquals($manager->getData(), 'error_test');
    }
}