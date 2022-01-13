<?php
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

    public function getProductID()
    {
        global $db;
        $sku = $this->getSKU();
        $query = 'SELECT id FROM Products where sku = :sku';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public function checkProductSKU()
    {
        global $db;
        $sku = $this->getSKU();
        $query = 'SELECT sku FROM Products where sku = :sku';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return json_encode($result);
    }
}
