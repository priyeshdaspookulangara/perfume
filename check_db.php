<?php
include_once 'koen/includes/db.php';
$res = $conn->query("SELECT id, name FROM products");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - Name: " . $row['name'] . "\n";
}
?>
