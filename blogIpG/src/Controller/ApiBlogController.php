<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\BlogApiServices;
use App\Entity\Blog;

/**
 * Class ApiBlogController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class ApiBlogController
{
    private $blogRepository;
    private $service;

    public function __construct(BlogRepository $blogRepository, BlogApiServices $service)
    {
        $this->blogRepository = $blogRepository;
        $this->service = $service;
    }

    /**
     * Api que devuelve un json con todos los posts del blog.
     */
    #[Route('posts', name: 'get_all_posts', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $posts = $this->blogRepository->findAll();
        $autors = $this->service->getAutors();
        $arrayPosts = [];

        //se recorren para encontrar el autor.
        foreach ($posts as $post) {
            $autor = $autors[$post->getAutor() -1];
            $post = json_decode(json_encode($post), true);
            $post['autor'] = $autor;
            $arrayPosts[] = $post;
        }

        return new JsonResponse($arrayPosts, Response::HTTP_OK);
    }

    /**
     * Api crea un post en el blog y lo manda por jsonplaceholder
     */
    #[Route('addPost', name: 'add_post', methods: ['POST'])]
    public function addPost(Request $request, BlogApiServices $service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['title']) || empty($data['body']) || empty($data['autor']) || ! in_array($data['autor'], [1,2,3,4,5,6,7,8,9,10])) {
            return new JsonResponse('Error: Bad Request!', 400);
        }

        $autors = $this->service->getAutors();

        //Creamos nueva entidad.
        $post = new Blog();
        $post->setTitle($data['title']);
        $post->setBody($data['body']);
        $post->setAutor($data['autor']);
        $autor = $autors[$post->getAutor() -1];

        //Se envia a Api el blog creado por api.
        $this->service->sendPost($post);

        //Se persiste el Blog
        $this->blogRepository->add($post, true);

        //Se convierte en array para meter el autor.
        $arrayPost = json_decode(json_encode($post), true);
        $arrayPost['autor'] = $autor;

        return new JsonResponse($arrayPost, Response::HTTP_OK);
    }
}
