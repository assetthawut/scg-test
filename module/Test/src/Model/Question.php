<?php 

    namespace Test\Model;

    use Zend\Cache\StorageFactory;
    use Zend\Cache\Storage\Adapter\Memcached;
    use Zend\Cache\Storage\StorageInterface;
    use Zend\Http\Request;
    use Zend\Http\Response;
    use Zend\Http\Client;
    use Zend\Json\Json;

    class Question {



        public function question1($currentData){
                 
            return $this->findNextAlphabet($currentData);

        }

        public function quetion1GetDataFromCache(){
            $currentData = [];
            $cache =  $this->cacheData(3600,' question1');
        
            if($cache->hasItem('question1')){
               
                $currentData = $cache->getItem('question1');
            }

            return  $currentData;
        }

        public function findNextAlphabet($currentData){
       
            
            // Rule : ((currentPostion + 1) * 2) + currentValue ); 

             $nextData = [];
             $currentData = $currentData; 
             $sizeOfArray = sizeof($currentData);

           
             $lastValue   = end($currentData);
            //  cast to intger;
             $lastValue  = (int)$lastValue ;
             $nextValue   = ($sizeOfArray * 2) + $lastValue;
             array_push($currentData,$nextValue);
             $startData   = $currentData;

             $cache =  $this->cacheData(3600,' question1'); 
             $cache->setItem('question1', $startData);

             return $startData;
            
            


        }

   

        public function getAllResturant($url,$query,$apiKey){
          // store data for 1 hour.
          $cache =  $this->cacheData(3600,'getAllResturant');
          if(!$cache->hasItem('getAllResturantObj')){
            try {
                $endPoint = $url.'query='.$query.'&key='.$apiKey;     
                $endPoint = (string)$endPoint;                        
                $client = new Client($endPoint);
                $response = $client->send();
                $data = $response->getBody();
                $result = Json::decode($data);
                $cache->setItem("getAllResturantObj",  $result);
                return $result;
            } catch(\Exception $e){
                echo $e;
                exit;
            }   
          }
          $result = $cache->getItem("getAllResturantObj");
          return $result;
        }

        
        
        public function cacheData($time, $namespace){

            $cache = StorageFactory::factory([
                'adapter' => [
                    'name' => 'filesystem',
                    'options' => [
                        'namespace' => $namespace,
                        'ttl' => $time,
                    ],
                ],
                'plugins' => [
                    // Don't throw exceptions on cache errors
                    'exception_handler' => [
                        'throw_exceptions' => true
                    ],
                    'Serializer',
                ],
            ]);
            return $cache;
        }


       



        




           


    }