<?php

// src/Controller/BlogController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BlogApiServices;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Blog;
use App\Form\Type\BlogType;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controlador del blog
 */
#[Route('/', requirements: ['_locale' => 'en'], name: 'blog_')]
class BlogController extends AbstractController
{
    /**
     * Listado de posts
     */
    #[Route('/', name: 'list')]
    public function list(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Blog::class)->findBy(
            array(),
            array('id' => 'DESC')
        );

        return $this->render('blog/list.html.twig', ['posts'=> $posts]);
    }

    /**
    * Función para visualizar un post
    */
    #[Route('/show/{id}', name: 'show')]
    public function show(EntityManagerInterface $em, BlogApiServices $service, int $id): Response
    {
        $post = $em->getRepository(Blog::class)->find($id);
        $arrayPost = null;
        if ($post) {
            $autor = $service->getAutor($post->getAutor());
            $arrayPost = ['blog' => $post, 'autor' => $autor];
        }

        return $this->renderForm('blog/posted.html.twig', [
            'post' => $arrayPost,
        ]);
    }

    /**
     * Esta función persistirá en BBDD la entidad Blog
     * también enviará el Blog por API para que quede actualizado si no existe ya.
     */
    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em, BlogApiServices $service, Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $post = new Blog();

        $form = $this->createForm(BlogType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $post = $form->getData();
            $post->setCreatedAt(new \DateTime("now"));

            //Se actualiza el blog creado en API
            $post = $service->sendPost($post);

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('blog_list');
        }
        return $this->renderForm('blog/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Funcion que borrará un post de la BBDD
     */
    #[Route('/delete', name: 'delete')]
    public function delete(EntityManagerInterface $em, Request $request): Response
    {
        return $this->redirectToRoute('blog_list');
    }

    /**
     * funcion que actualizará los Blogs obtenidos de jsonplaceholder 
     */
    #[Route('/update', name: 'update')]
    public function updatePosts(EntityManagerInterface $em, BlogApiServices $service)
    {
        $postsApi = $service->getPosts();
        $autorsApi = $service->getAutors();

        foreach ($postsApi as $postApi) {
            $post = $em->getRepository(Blog::class)->findOneByCodigo($postApi['id']);

            $autorApi = $autorsApi[$postApi['userId'] - 1];
            if (!$post instanceof Blog) {
                $post = new Blog();
                $post->setCreatedAt(new \DateTime("now"));
                $em->persist($post);
            }
            $post->setAutor($autorApi['id']);
            $post->setBody($postApi['body']);
            $post->setCodigo($postApi['id']);
            $post->setTitle($postApi['title']);
            $post->setUpdateAt(new \DateTime("now"));
        }
        $em->flush();
        return $this->redirectToRoute('blog_list');
    }
}
