<?php
include_once 'Product.php';

class DVD extends Product
{
  private $pivoteProductData;

  public function __construct()
  {
    parent::__construct();
    $this->pivoteProductData = array("size" => NULL);
  }

  public function setPivoteProductData($data)
  {
    $this->pivoteProductData["size"] = $data["size"];
  }

  public function getPivotProductData()
  {
    return $this->pivoteProductData;
  }
}
