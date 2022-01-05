<?php
interface DatabaseInteraction
{
    public function populate($hash);
    public function commitProductToDB($conn);
    public function commitTypeToDB($conn, $product_id);
}

abstract class Product
{
    private $sku;
    private $name;
    private $price;

    public function setSKU($sku)
    {
        $this->sku = $sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getSKU()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
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

class DVD extends Product implements DatabaseInteraction
{
    private $size;
    private $type;

    public function __construct()
    {
        $this->type = "DVD";
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }


    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function populate($hash)
    {
        $this->setSKU($hash->sku);
        $this->setName($hash->name);
        $this->setPrice($hash->price);
        $this->setSize($hash->size);
    }

    public function commitProductToDB($conn)
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

    public function commitTypeToDB($conn, $product_id)
    {
        // $pivot = intval($product_id);
        // echo json_decode($product_id);
        $size = $this->getSize();
        $sql = "INSERT INTO DVDS (product_id, size) VALUES (:product_id, :size)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':size', $size);
        $stmt->execute();
    }
}

class Furniture extends Product implements DatabaseInteraction
{
    private $type;
    private $width;
    private $height;
    private $length;

    public function __construct()
    {
        $this->type = "Furniture";
    }

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

    public function getType()
    {
        return $this->type;
    }

    public function populate($hash)
    {
        $this->setSKU($hash->sku);
        $this->setName($hash->name);
        $this->setPrice($hash->price);
        $this->setWidth($hash->width);
        $this->setHeight($hash->height);
        $this->setLength($hash->length);
    }

    public function commitProductToDB($conn)
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

    public function commitTypeToDB($conn, $product_id)
    {
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

class Book extends Product implements DatabaseInteraction
{
    private $weight;
    private $type;

    public function __construct()
    {
        $this->type = "Book";
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getType()
    {
        return $this->type;
    }

    public function populate($hash)
    {
        $this->setSKU($hash->sku);
        $this->setName($hash->name);
        $this->setPrice($hash->price);
        $this->setWeight($hash->weight);
    }

    public function commitProductToDB($conn)
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

    public function commitTypeToDB($conn, $product_id)
    {
        $weight = $this->getWeight();
        $sql = "INSERT INTO Books (product_id, weight) VALUES (:product_id, :weight)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':weight', $weight);
        $stmt->execute();
    }
}
