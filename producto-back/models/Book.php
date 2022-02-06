<?php
include_once 'Product.php';

class Book extends Product
{
  private $pivoteProductData;

	public function __construct()
  {
    parent::__construct();
    $this->pivoteProductData = array("weight" => NULL);
  }

  public function setPivoteProductData($data)
  {
    $this->pivoteProductData["weight"] = $data["weight"];
  }

  public function getPivotProductData()
  {
    return $this->pivoteProductData;
  }
}
