<?php

require "clsAPI.php";
require "clsProperty.php";
require "clsRepository.php";


//this code will retrieve a list of properties from EasyBroker API
//in a future release pagination could be implemented and other search methods

$configManager =  new configManager ('https://api.stagingeb.com/v1/','05mh61963tpe2bi7efwoamhciwt0h5');
$config = $configManager->getconfig();

$propertyRepository = new PropertyRepositoryAPI($config);
$propertyController = new PropertyController($propertyRepository);
$propertyList = $propertyController->getAll();
$propertyController->renderPropertiesList($propertyList);
echo "\n THE END  \n ";




?>
