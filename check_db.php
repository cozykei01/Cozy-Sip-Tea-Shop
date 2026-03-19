<?php
require_once 'app/config/database.php';
$database = new Database();
$db = $database->getConnection();
if ($db) {
    try {
        $stmt = $db->query("DESCRIBE favorites");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
