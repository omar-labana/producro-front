<?php
include_once 'Product.php';
include_once 'OperationInterface.php';

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
