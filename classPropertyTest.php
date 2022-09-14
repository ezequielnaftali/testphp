<?php


class propertyTest  extends \PHPUnit\Framework\TestCase
{
    public function testPropertyList(){
        $configManager =  new configManager ('https://api.stagingeb.com/v1/','05mh61963tpe2bi7efwoamhciwt0h5');
        $config = $configManager->getconfig();
        $propertyRepository = new PropertyRepositoryAPI($config);
        $propertyController = new PropertyController($propertyRepository);
        $propertyList = $propertyController->getAll();
        $this->assertTrue(count($propertyList) > 0, 'verifies API is getting results');
        $this->assertContains($propertyList,'Title','verifies the existence of the title field in result');

        //test a failure in API (should return an exception)
        $configManager =  new configManager ('https://api.stagingeb.com/v1/','INVALID-TOKEN');
        $config = $configManager->getconfig();
        
        $propertyRepository = new PropertyRepositoryAPI($config);
        $propertyController = new PropertyController($propertyRepository);
        $propertyList = $propertyController->getAll();
        $this->expectException("Exception");
        //in the future should check differente exceptions and codes

    }   
}
?>
