<?php
include_once '../config/Database.php';

class Interaction
{
  private $conn;
  private $product;
  private $tables = ["Book" => "Books", "DVD" => "DVDS", "Furniture" => "Furniture"];
  public function __construct()
  {
    $database = new Database();
    $db = $database->connect();
    $this->conn = $db;
  }

  public function setProduct($product)
  {
    $this->product = $product;
  }

  public function getProduct()
  {
    return $this->product;
  }

  public function getTableName()
  {
    return $this->tables[$this->product->getType()];
  }

  public function getProductID()
  {
    $sku = $this->product->getSKU();
    $sql = "SELECT id FROM Products WHERE sku = :sku";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["id"];
  }

  public function insertBaseProductData()
  {
    $baseProductData = $this->getProduct()->getBaseProductData();
    $sql = "INSERT INTO products (name, price, sku, type) VALUES (:name, :price, :sku, :type)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name', $baseProductData['name']);
    $stmt->bindParam(':price', $baseProductData['price']);
    $stmt->bindParam(':sku', $baseProductData['sku']);
    $stmt->bindParam(':type', $baseProductData['type']);
    $stmt->execute();
  }

  public function insertPivotProductData()
  {
    $pivotProductData = $this->getProduct()->getPivotProductData();
    $tableName = $this->getTableName();
    $columnNames = implode(", ", array_keys($pivotProductData));
    $columnPlaceholders = ":" . implode(", :", array_keys($pivotProductData));
    $product_id = $this->getProductID();
    $sql = "INSERT INTO $tableName (product_id, $columnNames) VALUES (:product_id, $columnPlaceholders)";
    $stmt = $this->conn->prepare($sql);
    foreach ($pivotProductData as $key => $value) {
      $stmt->bindParam(':' . $key, $value);
    }
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
  }

  public function insertProduct()
  {
    $this->insertBaseProductData();
    $this->insertPivotProductData();
    echo "Product added successfully";
  }

  public function deleteProduct()
  {
    $sku = $this->getProduct()->getSKU();
    $sql = "DELETE FROM Products WHERE sku = :sku";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
  }

  private function readTable($tableName)
  {
    $sql = "SELECT * FROM Products INNER JOIN " . $tableName . " ON Products.id = " . $tableName . ".product_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function readAll()
  {
    $dvds = $this->readTable('DVDS');
    $books = $this->readTable('Books');
    $furniture = $this->readTable('Furniture');
    $allProducts = array_merge($dvds, $books, $furniture);

    usort($allProducts, function ($a, $b) {
      return $a['id'] - $b['id'];
    });

    $obj = new stdClass;
    $obj->data = $allProducts;
    echo json_encode($obj);
  }
}
