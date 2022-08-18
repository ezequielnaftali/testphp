<?php



 class PropertyController
 {
     private $repository;
 
     public function __construct(getPropertyInterface $repository)
     {
         $this->repository = $repository;    
     }  
     public function getAll() // returns all the properties from a repository call
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



// this part should be separated in another class file for repositories only

 interface getPropertyInterface{
    public function getAll();
    public function getOne($id);
    
  }

  
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

  ?>