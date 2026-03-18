<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'app/config/database.php';
require_once 'app/models/Product.php';

$database = new Database();
$db = $database->getConnection();
if ($db) {
    echo "DB Connected\n";
    $productModel = new Product($db);
    $eventProducts = $productModel->getEventProducts(4);
    echo "Count: " . count($eventProducts) . "\n";
    print_r($eventProducts);
} else {
    echo "DB Failed\n";
}
?>
