<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';

$database = new Database();
$db = $database->connect();

function getDVDS($conn)
{
  $sql = "SELECT * FROM Products INNER JOIN DVDS on Products.id = DVDS.product_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getBooks($conn)
{
  $sql = "SELECT * FROM Products INNER JOIN Books on Products.id = Books.product_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getFurniture($conn)
{
  $sql = "SELECT * FROM Products INNER JOIN Furniture on Products.id = Furniture.product_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

$dvds = getDVDS($db);
$books = getBooks($db);
$furniture = getFurniture($db);

$allProducts = array_merge($dvds, $books, $furniture);
usort($allProducts, function ($a, $b) {
  return $a['id'] - $b['id'];
});
$obj = new stdClass;
$obj->data = $allProducts;
echo json_encode($obj);
