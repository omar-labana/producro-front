<?php
include_once 'Product.php';

class Furniture extends Product
{
	private $width;
	private $height;
	private $length;

	public function setWidth($width)
	{
		$this->width = $width;
	}

	public function setHeight($height)
	{
		$this->height = $height;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function populate($data)
	{
		parent::populate($data);
		$this->setWidth($data->width);
		$this->setHeight($data->height);
		$this->setLength($data->length);
	}

	public function addProduct($conn)
	{
		$product_id = parent::addProduct($conn);
		$width = $this->getWidth();
		$height = $this->getHeight();
		$length = $this->getLength();
		$sql = "INSERT INTO Furniture (product_id, width, height, length) VALUES (:product_id, :width, :height, :length)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':product_id', $product_id);
		$stmt->bindParam(':width', $width);
		$stmt->bindParam(':height', $height);
		$stmt->bindParam(':length', $length);
		$stmt->execute();
	}
}
