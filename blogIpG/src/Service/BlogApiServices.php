<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\Persistence\ManagerRegistry;

class BlogApiServices
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * funcion que cogerá todo los posts (Cogerá los Blog de Api y los persistidos en BBDD.)
     */
    public function getPosts()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts';
        $return = $this->sendCurl($url);
        $response = $return['response'];
        $error = $return['error'];

        if ($error) {
            throw new \Exception($error, 100);
        }

        return $response;
    }

    /**
     * funcion que devolverá todos los autores de jsonplaceholder.
     */
    public function getAutors()
    {
        $url = 'https://jsonplaceholder.typicode.com/users/';
        $return = $this->sendCurl($url);
        $response = $return['response'];
        $error = $return['error'];

        if ($error) {
            throw new \Exception($error, 100);
        }

        return $response;
    }

    /**
     * funcion que devolverá el autor pasandole un id.
     */
    public function getAutor($id)
    {
        $url = 'https://jsonplaceholder.typicode.com/users/'.$id;
        $return = $this->sendCurl($url);
        $response = $return['response'];
        $error = $return['error'];

        if ($error) {
            throw new \Exception($error, 100);
        }

        return $response;
    }

    /**
     * funcion envia el post a jsonplaceholder
     */
    public function sendPost($post)
    {
        $array = [
            'userId' => $post->getAutor(),
            'title' => $post->getTitle(),
            'body' => $post->getBody()
        ];

        $json = json_encode($array);

        $url = 'https://jsonplaceholder.typicode.com/posts';
        $return = $this->sendCurl($url, 'POST', $json);

        $response = $return['response'];
        $error = $return['error'];

        if ($error) {
            throw new \Exception($error, 100);
        }

        //Se actualiza el post creado en API
        $post->setCodigo($response['id'] ?? null);

        return $post;
    }

    /**
     * funcion base para el envío de CURL
     */
    private function sendCurl($url, $type = 'GET', $json = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $type,
      ));

        if ($json) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
          ));
        }

        //setting them to false.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = json_decode(curl_exec($curl), true);
        $error = json_decode(curl_error($curl), true);
        curl_close($curl);

        return ['response' =>$response, 'error' => $error];
    }
}
