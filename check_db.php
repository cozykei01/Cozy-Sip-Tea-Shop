<?php
$conn = new PDO("mysql:host=localhost", "root", "");
$stmt = $conn->query("SHOW DATABASES");
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
?>
