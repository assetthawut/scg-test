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

    
}