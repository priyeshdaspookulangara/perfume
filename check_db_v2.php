<?php
include_once 'koen/includes/db.php';
echo "--- PRODUCTS ---\n";
$res = $conn->query("SELECT id, name, category_id FROM products");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - Name: " . $row['name'] . " - Cat ID: " . $row['category_id'] . "\n";
}
echo "\n--- CATEGORIES ---\n";
$res = $conn->query("SELECT id, name FROM categories");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - Name: " . $row['name'] . "\n";
}
?>
