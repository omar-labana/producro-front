<?php
abstract class Product
{
	private $name;
	private $price;
	private $sku;
	private $type;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setSku($sku)
	{
		$this->sku = $sku;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getSku()
	{
		return $this->sku;
	}

	public function getType()
	{
		return $this->type;
	}

	public function populate($data)
	{
		$this->setName($data->name);
		$this->setPrice($data->price);
		$this->setSku($data->sku);
		$this->setType($data->type);
	}

	public function addBaseProduct($conn)
	{
		$sku = $this->getSKU();
		$name = $this->getName();
		$price = $this->getPrice();
		$type = $this->getType();
		$sql = "INSERT INTO Products (sku, name, price, type) VALUES (:sku, :name, :price, :type)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':sku', $sku);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':price', $price);
		$stmt->bindParam(':type', $type);
		$stmt->execute();
	}

	public function getProductID($conn)
	{
		$sku = $this->getSKU();
		$sql = "SELECT id FROM Products WHERE sku = :sku";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':sku', $sku);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result['id'];
	}

	public function addProduct($conn)
	{
		$this->addBaseProduct($conn);
		$id = $this->getProductID($conn);
		return $id;
	}

	public function deleteProduct($conn)
	{
		$sku = $this->getSKU();
		$sql = "DELETE FROM Products WHERE sku = :sku";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':sku', $sku);
		$stmt->execute();
	}
}
