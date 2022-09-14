<?php 

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
?>