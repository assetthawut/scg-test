<?php 


namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Test\Form\QuestionForm;
use Test\Model\Question;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Memcached;
use Zend\Cache\Storage\StorageInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Http\Client;
use Zend\Json\Json;




class ScgController extends AbstractActionController
{
    public function indexAction()
    {
      // $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
      // print_r($root);
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function question1Action(){
        $form = new QuestionForm();
        $answer  = [3,5,9,15];


        $quest1 = new Question();

        if($this->getRequest()->isPost()) {
      
            
            // Retrieve form data from POST variables
            $data = $this->params()->fromPost();     
            $tempData = explode("|",$data['my-hidden']); 
       

            $answer = $quest1->question1($tempData);
             
          }


        
          if(count($quest1->quetion1GetDataFromCache()) > 0){

            $answer = $quest1->quetion1GetDataFromCache();

          }


       

        return array('form' =>  $form,'answer' => $answer);

    } 







    public function getrestaurantAction(){

        // set header 
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $apiKey     = "AIzaSyBnqWDF_vJPdFx4BdkhZ5H-TVWqmz-lJrw";
        $query      = "restaurants+in+Bangsue";
        $url        = "https://maps.googleapis.com/maps/api/place/textsearch/json?"; // type json

        $question  = new Question();
        $result = $question->getAllResturant($url,$query,$apiKey);
        

         echo json_encode($result);
         
        
        // disable layout.
        $view = new \Zend\View\Model\ViewModel();
        $view->setTerminal(true);
        return $view;
               
        
    }


    public function lineAction(){
      if($this->getRequest()->isPost()) {
        $body 	   = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];
        // log body and signature
        file_put_contents('php://stderr', 'Body: '.$body);
        // is LINE_SIGNATURE exists in request header?
        if (empty($signature)){
          // return $response->withStatus(400, 'Signature not set');
          return; 
        }
        // is this request comes from LINE?
        if($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature)){
          // return $response->withStatus(400, 'Invalid signature');
          return;
        }
        // init bot
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('cUxb83lhQFSLy4Ezs/im8hOUp7ci1CIBMZvj+5VDck4fJ8onlzMloqM95nKDs1Hp4LGj3ujlvOyFmFzeFb+/nEPOlSbHgnELtszqBFCaYcs9cMw2m+jDHh6Nj74jZsYheXQPHe3GRo8n3TCSv4OAugdB04t89/1O/w1cDnyilFU=');
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'baacaa0d19f543b23583afd2059b9a74']);
        $data = json_decode($body, true);
        foreach ($data['events'] as $event)
        {
          $userMessage = $event['message']['text'];
          // if(strtolower($userMessage) == 'halo')
          // {
            $message = "Hello Joe";
                  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
            $result = $bot->replyText($event['replyToken'], $message);
            return $result->getHTTPStatus() . ' ' . $result->getRawBody();
          // }
        }
      }
      $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
      $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
      // print_r($httpClient);
      // disable layout.
      // $view = new \Zend\View\Model\ViewModel();
      // $view->setTerminal(true);
      // return $view;
      // exit();
    }
    
}