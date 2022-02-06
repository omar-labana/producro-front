<?php
abstract class Product
{
  private $baseProductData;

  public function __construct()
  {
    $this->baseProductData = array("name" => NULL, "price" => NULL, "sku" => NULL, "type" => NULL);
  }

  public function setBaseProductData($data)
  {
    $this->baseProductData["name"] = $data["name"];
    $this->baseProductData["price"] = $data["price"];
    $this->baseProductData["sku"] = $data["sku"];
    $this->baseProductData["type"] = $data["type"];
  }

  public function getBaseProductData()
  {
    return $this->baseProductData;
  }

  public function getType(){
    return $this->baseProductData["type"];
  }
  
  public function getSKU(){
    return $this->baseProductData["sku"];
  }
}
