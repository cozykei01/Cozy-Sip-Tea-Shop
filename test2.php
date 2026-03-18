<?php
require 'app/config/database.php';
require 'app/models/Product.php';
$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$eventProducts = $productModel->getEventProducts(4);
print_r($eventProducts);
?>
