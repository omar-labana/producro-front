<?php
include_once 'Product.php';

class Book extends Product
{
	private $weight;

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function populate($data)
	{
		parent::populate($data);
		$this->setWeight($data->weight);
	}

	public function addProduct($conn)
	{
		$product_id = parent::addProduct($conn);
		$weight = $this->getWeight();
		$sql = "INSERT INTO Books (product_id, weight) VALUES (:product_id, :weight)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':product_id', $product_id);
		$stmt->bindParam(':weight', $weight);
		$stmt->execute();
	}
}
