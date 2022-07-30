<?php
namespace App\Tests\UnitTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExampleTest extends WebTestCase{
    public function test_example_result() : void{
        $this->assertEquals('ok','ok');
    }
}