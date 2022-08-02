<?php
namespace App\Tests\UnitTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Blog;

class BlogTests extends WebTestCase{
    public function createSimpleBlog() : void{
        $blog = new Blog();

        $this->assertEquals($blog instanceof Blog, true);
    }
}