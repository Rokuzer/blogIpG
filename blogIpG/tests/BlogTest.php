<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\BlogApiServices;
use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;

class BlogTest extends WebTestCase
{
    public function test_create_simple_blog(): void
    {
        $post = new Blog();
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $post->setTitle('Titulo');
        $post->setBody('Body');
        $post->setAutor(1);
        $em->persist($post);
        $em->flush();
        $this->assertEquals($post instanceof Blog, true);
    }

    public function test_edit_simple_blog(): void
    {
        static::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $post = $em->getRepository(Blog::class)->findBy([], array('id'=>'DESC'), 1, 0)[0];
        if ($post) {
            $post->setTitle('Titulo2');
            $em->flush();
        }
        $this->assertEquals($post instanceof Blog, true || null);
    }
}
