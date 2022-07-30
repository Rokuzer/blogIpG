<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/blog", requirements={"_locale": "en|es|fr"}, name="blog_")
 */
class BlogController extends AbstractController
{

 /**
     * @Route("/", name="blog_list")
     */
    public function list()
    {
        $number = random_int(0, 100);

        return $this->render('blog/base.html.twig', [
            'number' => $number,
        ]);
    }

    /**
    * @Route("/show/{id}", methods={"GET","HEAD"})
    */
    public function show(int $id, Request $request): Response
    {
        // ... return a JSON response with the post
    }

    /**
     * @Route("/create/{id}", methods={"POST"})
     * @Route("/edit/{id}", methods={"PUT"})
     * Llamará a la funcion de BlogApiController.
     */
    public function edit(int $id, Request $request): Response
    {
        // ... edit a post
    }
}