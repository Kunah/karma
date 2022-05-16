<?php

// Run this command to start your tests : 
// vendor\bin\phpunit ./tests 
namespace Tests;

use PHPUnit\Framework\TestCase;

include 'src/config/config.php';

final class ExampleTest extends TestCase {

    private $manager;

    /**
     * @before
     */
    public function initTestEnvironment(){
        $this->manager = new \App\Models\ExampleManager();
    }

    public function testExampleSuccess(){
        $this->assertEquals($this->manager->getData(), 'success_test');
    }

    public function testExampleError(){
        $this->assertEquals($this->manager->getData(), 'error_test');
    }
}