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
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/blog", requirements={"_locale": "en|es|fr"}, name="blog_")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/", name="list")
     */
    public function list(BlogApiServices $service, EntityManagerInterface $em)
    {
        try{
            $posts = $em->getRepository(Blog::class)->findAll();
           /* $posts = $service->getPosts();
            $autors = $service->getAutors();
            $response = [];
            foreach($posts as $post){
                $response[] = ['post' => $post, 'autor' => $autors[$post['userId'] - 1]];
            }*/

        }catch (\Exception $ex) {
            return $this->render('blog/list.html.twig', ['error'=>$ex->getMessage()]);
        }
        return $this->render('blog/list.html.twig',['posts'=> $posts]);
    }

    /**
    * @Route("/show/{id}", name="show" )
    */
    public function show(int $id, Request $request): Response
    {
        // ... return a JSON response with the post
    }

    /**
     * Esta función persistirá en BBDD la entidad Blog
     * también enviará el Blog por API para que quede actualizado si no existe ya.
     * 
     * @Route("/create", name="create")
     */
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $blog = new Blog();
        
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $blog = $form->getData();
            
            $em->persist($blog);
            $em->flush();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('blog_list');
        }
        return $this->renderForm('blog/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * funcion que actualizará los Blogs
     */
    public function updatePosts (){
        $posts = $service->getPosts();
        $autors = $service->getAutors();
    }
}