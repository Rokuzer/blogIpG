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
        try{
            $posts = $this->getPosts();
            $autors = $this->getAutors();
            $response = [];
            foreach($posts as $post){
                $response[] = ['post' => $post, 'autor' => $autors[$post['userId'] - 1]];
            }

        }catch (\Exception $ex) {
            return $this->render('blog/list.html.twig', ['error'=>$ex->getMessage()]);
        }
        return $this->render('blog/list.html.twig',['response'=> $response]);
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
     */
    public function create(int $id, Request $request): Response
    {
        // ... edit a post
    }

    /**
     * funcion que cogerá todo los posts
     */
    private function getPosts (){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://jsonplaceholder.typicode.com/posts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        //setting them to false.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = json_decode(curl_exec($curl), true);
        $error = json_decode(curl_error($curl), true);
        curl_close($curl);
        if($error){
            throw new \Exception($error, 100);
        }

        return $response;
    }

    /**
     * funcion que devolverá el autor pasandole un id.
     */
    private function getAutors (){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://jsonplaceholder.typicode.com/users/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        //setting them to false.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = json_decode(curl_exec($curl), true);
        $error = json_decode(curl_error($curl), true);
        curl_close($curl);
        if($error){
            throw new \Exception($error, 100);
        }

        return $response;
        
    }
}