<?php
require 'app/config/database.php';
$db = (new Database())->getConnection();
$stmt = $db->query('SELECT product_name, event_status FROM products');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);
?>
