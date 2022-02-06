<?php
include_once 'Product.php';

class Furniture extends Product
{
  private $pivoteProductData;

  public function __construct()
  {
    parent::__construct();
    $this->pivoteProductData = array("width" => NULL, "height" => NULL, "length" => NULL);
  }

  public function setPivoteProductData($data)
  {
    $this->pivoteProductData["width"] = $data["width"];
    $this->pivoteProductData["height"] = $data["height"];
    $this->pivoteProductData["length"] = $data["length"];
  }

  public function getPivotProductData()
  {
    return $this->pivoteProductData;
  }
}
