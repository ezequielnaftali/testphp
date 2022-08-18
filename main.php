<?php

require "clsAPI.php";
 
class PropertyRepositoryAPI implements getPropertyInterface{

  private $config;  //API configuration object
  public function __construct($configObject){
    $this->config = $configObject;    
  }
  public function getAll()
  {
    $prop = APICall::get($this->config, 'properties',array()); //in the future implement other parameters like pagination   
    return $prop;
  }
  public function getOne($id){
   //TBD in the future
  }
}



class configManager{
  private $endpoint;
  private $token;
  //in the future this can be overloaded to get config info from better sources
  public function __construct($api_url, $token){
        $this->endpoint = $api_url;
        $this->token = $token;
  }
  public function getConfig() 
  {
    
    $config = array('endpoint'=> "".$this->endpoint."");
    $config += array('token'=> "".$this->token."");
    return $config;
  }

}


interface getPropertyInterface{
  public function getAll();
  public function getOne($id);
  
}



 class PropertyController
 {
     private $repository;
 
     public function __construct(getPropertyInterface $repository)
     {
         $this->repository = $repository;    
     } 
     public function getAll() // returns all the properties from repository call
     {
         $properties_data = $this->repository->getAll();
         $propertiesList = array();
         foreach($properties_data->content as $key => $val) {
          $propertiesList[] = new Property($val->title,$val->location,$val->operations[0]->amount,$val->operations[0]->currency);

         }
         return $propertiesList;
     }
     public function renderPropertiesList($listOfProperties){
        foreach($listOfProperties as $prop){          
          echo $prop->getDescription()."\n";  //console print the property 
        }

     }
 }






$configManager =  new configManager ('https://api.stagingeb.com/v1/','05mh61963tpe2bi7efwoamhciwt0h5');
$config = $configManager->getconfig();

$propertyRepository = new PropertyRepositoryAPI($config);
$propertyController = new PropertyController($propertyRepository);
$propertyList = $propertyController->getAll();
$propertyController->renderPropertiesList($propertyList);
echo "\n  \n ";




?>
