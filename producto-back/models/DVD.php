<?php
include_once 'Product.php';
include_once 'OperationInterface.php';

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
