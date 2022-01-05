<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));
$type = $data->type;
$product = new $type();
$product->populate($data);


function getProductID($sku)
{
    global $db;
    $query = 'SELECT id FROM Products where sku = :sku';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['id'];
}

function checkProductSKU($sku)
{
    global $db;
    $query = 'SELECT sku FROM Products where sku = :sku';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':sku', $sku);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return json_encode($result);
}

if (checkProductSKU($product->getSKU()) == "false") {
    $product->commitProductToDB($db);
    $product_id = getProductID($product->getSKU());
    $product->commitTypeToDB($db, $product_id);
    echo json_encode(
        array('message' => 'Product Created')
    );
} else {
    echo json_encode(
        array('message' => 'Product Already Exists')
    );
}
