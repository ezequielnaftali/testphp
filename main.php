<?php

require "clsAPI.php";
 
$config = array('endpoint'=>'https://api.stagingeb.com/v1/', 'token'=>'05mh61963tpe2bi7efwoamhciwt0h5');
//$prop = APICall::get($config, 'properties',array());
//var_dump($prop->content);
echo "\n";
$p = new Property('titulo', ' locacion', 400000, 'USD');
echo $p->getDescription();
echo "\n fin \n ";

class Property{

  private $title;
  private $location;
  private $price;
  private $currency;
  public function __construct($title, $location, $price, $currency){
    $this->title = $title;
    $this->location = $location;
    $this->price = $price;
    $this->currency = $currency;
  }
  public function getTitle()
  {
    return $this->title;    
  }
  public function getLocation(){
    return $this->location;
  }
  public function getPrice(){ 
    $price = $this->price." ".$this->currency;
    return $price;
  }
  public function getDescription(){
    return ($this->getTitle(). " " . $this->getLocation(). " " . $this->getPrice());
  }

}

abstract class Fruit {
  public $name;
  public $color;
  public function __construct($name, $color) {
    $this->name = $name;
    $this->color = $color;
    
  }
  public function intro() {
    echo "The fruit is {$this->name} and the colour is {$this->color}.";
  }
  public abstract function message();
}

// Strawberry is inherited from Fruit
class Strawberry extends Fruit {
  public function message() {
    echo "Am I a fruit or a berry? ";
  }
}

//$strawberry = new Strawberry("Strawberry", "red");
//$strawberry->message();
//$strawberry->intro();
?>
