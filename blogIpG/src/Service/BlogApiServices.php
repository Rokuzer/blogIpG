<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\Persistence\ManagerRegistry;
class BlogApiServices
{
   private $em;

   public function __construct(EntityManagerInterface $entityManager){
      $this->em = $entityManager;
   }

    /**
     * funcion que cogerá todo los posts (Cogerá los Blog de Api y los persistidos en BBDD.)
     */
    public function getPosts (){
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
     * funcion que cogerá todo los posts
     */
    public function getPost (){
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
  public function getAutors (){
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

    /**
   * funcion que devolverá el autor pasandole un id.
   */
  public function getAutor($id){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://jsonplaceholder.typicode.com/users/'.$id,
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
  public function sendPost ($post){
    $array = [
      'userId' => $post->getAutor(),
      'title' => $post->getTitle(),
      'body' => $post->getBody()
    ];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://jsonplaceholder.typicode.com/posts',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
            "userId": 1,
            "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            "body": "quia et suscipit\\nsuscipit recusandae consequuntur expedita et cum\\nreprehenderit molestiae ut ut quas totam\\nnostrum rerum est autem sunt rem eveniet architecto"
        }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
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

  private function sendCurl($url, $body){
      $curl = curl_init();
      
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
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