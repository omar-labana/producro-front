<?php
include_once 'Product.php';

class DVD extends Product
{
	private $size;

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function populate($data)
	{
		parent::populate($data);
		$this->setSize($data->size);
	}

	public function addProduct($conn)
	{
		$product_id = parent::addProduct($conn);
		$size = $this->getSize();
		$sql = "INSERT INTO DVDS (product_id, size) VALUES (:product_id, :size)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':product_id', $product_id);
		$stmt->bindParam(':size', $size);
		$stmt->execute();
	}
}
