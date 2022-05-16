<?php

// Run this command to start your tests : 
// vendor\bin\phpunit ./tests 
namespace Tests;

use App\Models\ExampleManager;
use PHPUnit\Framework\TestCase;

include 'src/config/config.php';

final class ExampleTest extends TestCase {

    private $manager;

    /**
     * @before
     */
    public function initTestEnvironment(){
        $this->manager = new ExampleManager();
    }

    public function testExampleSuccess(){
        $this->assertEquals($this->manager->getData(true), 'success_test');
    }

    public function testExampleError(){
        $this->assertEquals($this->manager->getData(true), 'error_test');
    }

    public function testExampleMock(){
        $stub = $this->getMockBuilder(ExampleManager::class)->getMock();
        $stub->method('getData')->with("test")->willReturn("mock_test");
        $this->assertSame($stub->getData("test"), "mock_test");
    }
}