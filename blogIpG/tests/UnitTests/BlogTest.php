<?php
namespace App\Tests\UnitTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\BlogApiServices;
use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;

class BlogTest extends WebTestCase{
    public function test_create_simple_blog() : void{
        $blog = new Blog();
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $blog->setTitle('Titulo');
        $blog->setBody('Body');
        $blog->setAutor(1);
        $em->persist($blog);
        $em->flush();
        $this->assertEquals($blog instanceof Blog, true);
    }

    public function test_edit_simple_blog() : void{
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $blog = $em->getRepository(Blog::class)->findBy([],array('id'=>'DESC'),1,0)[0];
        if($blog){
            $blog->setTitle('Titulo2');
            $em->flush();
        }
        $this->assertEquals($blog instanceof Blog, true || NULL);
    }
}