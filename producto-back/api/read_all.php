<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/ReadProducts.php';

$database = new Database();
$db = $database->connect();

$res = new ReadProducts();
$res->readProducts($db);