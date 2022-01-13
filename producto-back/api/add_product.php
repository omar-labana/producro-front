<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Book.php';
include_once '../models/Furniture.php';
include_once '../models/DVD.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));
$type = $data->type;

$product = new $type();
$product->populate($data);
$product->InitializeTransaction($db);
