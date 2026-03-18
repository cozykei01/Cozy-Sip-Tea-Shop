<?php
require_once 'app/config/database.php';
require_once 'app/models/Product.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    $productModel = new Product($db);
    $eventProducts = $productModel->getEventProducts(0);
    
    echo "Total Event Products found: " . count($eventProducts) . "\n";
    foreach ($eventProducts as $product) {
        echo "- ID: {$product['product_id']}, Name: {$product['product_name']}, Status: {$product['event_status']}\n";
    }
} else {
    echo "Database connection failed.\n";
}
