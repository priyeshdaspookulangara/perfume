<?php
include_once 'koen/includes/db.php';
$res = $conn->query("SELECT * FROM product_sizes WHERE product_id = 1");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
