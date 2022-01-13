<?php
include_once 'Product.php';
include_once 'OperationInterface.php';

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

    public function InitializeTransaction($conn)
    {
        if ($this->checkProductSKU($this->getSKU()) == "false") {
            $this->commitProductToDB($conn);
            $product_id = $this->getProductID($this->getSKU());
            $this->commitTypeToDB($conn, $product_id);
            echo json_encode(
                array('message' => 'Product Created')
            );
        } else {
            echo json_encode(
                array('message' => 'Product Already Exists')
            );
        }
    }
}
