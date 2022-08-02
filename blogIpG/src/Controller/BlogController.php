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
 * @Route("/", requirements={"_locale": "en|es|fr"}, name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list(EntityManagerInterface $em)
    {
        $blogs = $em->getRepository(Blog::class)->findBy(
            array(),
            array('id' => 'DESC')
        );

        return $this->render('blog/list.html.twig', ['posts'=> $blogs]);
    }

    /**
    * @Route("/show/{id}", name="show" )
    */
    public function show(EntityManagerInterface $em, BlogApiServices $service, int $id): Response
    {
        $blog = $em->getRepository(Blog::class)->find($id);
        $autor = $service->getAutor($blog->getAutor());
        $post = ['blog' => $blog, 'autor' => $autor];

        return $this->renderForm('blog/posted.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * Esta función persistirá en BBDD la entidad Blog
     * también enviará el Blog por API para que quede actualizado si no existe ya.
     *
     * @Route("/create", name="create")
     */
    public function create(EntityManagerInterface $em, BlogApiServices $service, Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $blog = new Blog();

        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $blog = $form->getData();
            $blog->setCreatedAt(new \DateTime("now"));

            //Se actualiza el blog creado en API
            $response = $service->sendPost($blog);
            $blog->setCodigo($response['id']??null);

            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('blog_list');
        }
        return $this->renderForm('blog/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete(EntityManagerInterface $em, Request $request): Response
    {
        return $this->redirectToRoute('blog_list');
    }

    /**
     * funcion que actualizará los Blogs
     * @Route("/update", name="update")
     */
    public function updatePosts(EntityManagerInterface $em, BlogApiServices $service)
    {
        $postsApi = $service->getPosts();
        $autorsApi = $service->getAutors();

        foreach ($postsApi as $postApi) {
            $blog = $em->getRepository(Blog::class)->findOneByCodigo($postApi['id']);

            $autorApi = $autorsApi[$postApi['userId'] - 1];
            if (!$blog instanceof Blog) {
                $blog = new Blog();
                $blog->setCreatedAt(new \DateTime("now"));
                $em->persist($blog);
            }
            $blog->setAutor($autorApi['id']);
            $blog->setBody($postApi['body']);
            $blog->setCodigo($postApi['id']);
            $blog->setTitle($postApi['title']);
            $blog->setUpdateAt(new \DateTime("now"));
        }
        $em->flush();
        return $this->redirectToRoute('blog_list');
    }
}
