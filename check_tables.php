<?php
include_once 'koen/includes/db.php';
$res = $conn->query("SHOW TABLES LIKE 'product_images'");
if ($res->num_rows > 0) {
    echo "Table product_images exists.\n";
} else {
    echo "Table product_images DOES NOT exist.\n";
}
?>
