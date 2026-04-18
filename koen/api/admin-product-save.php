<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'CSRF validation failed']);
    exit();
}

$id = intval($_POST['id'] ?? 0);
$name = $_POST['name'] ?? '';
$category_id = intval($_POST['category_id'] ?? 0);
$scent_family = $_POST['scent_family'] ?? '';
$price = floatval($_POST['price'] ?? 0);
$compare_price = floatval($_POST['compare_price'] ?? 0);
$badge = $_POST['badge'] ?? '';
$rating = floatval($_POST['rating'] ?? 0);
$review_count = intval($_POST['review_count'] ?? 0);
$image = $_POST['image'] ?? '';
$scent_story = $_POST['scent_story'] ?? '';
$description = $_POST['description'] ?? '';
$top_notes = $_POST['top_notes'] ?? '';
$heart_notes = $_POST['heart_notes'] ?? '';
$base_notes = $_POST['base_notes'] ?? '';

if ($id > 0) {
    // Update
    $stmt = $conn->prepare("UPDATE products SET category_id = ?, name = ?, scent_family = ?, price = ?, compare_price = ?, badge = ?, rating = ?, review_count = ?, image = ?, scent_story = ?, description = ?, top_notes = ?, heart_notes = ?, base_notes = ? WHERE id = ?");
    $stmt->bind_param("issddsdissssssi", $category_id, $name, $scent_family, $price, $compare_price, $badge, $rating, $review_count, $image, $scent_story, $description, $top_notes, $heart_notes, $base_notes, $id);
} else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO products (category_id, name, scent_family, price, compare_price, badge, rating, review_count, image, scent_story, description, top_notes, heart_notes, base_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issddsdissssss", $category_id, $name, $scent_family, $price, $compare_price, $badge, $rating, $review_count, $image, $scent_story, $description, $top_notes, $heart_notes, $base_notes);
}

if ($stmt->execute()) {
    $product_id = $id > 0 ? $id : $conn->insert_id;

    // Handle sizes
    if (isset($_POST['sizes_ml']) && is_array($_POST['sizes_ml'])) {
        // Simple approach: delete existing sizes and re-insert
        $conn->query("DELETE FROM product_sizes WHERE product_id = $product_id");
        $stmt_size = $conn->prepare("INSERT INTO product_sizes (product_id, ml, price, stock) VALUES (?, ?, ?, ?)");
        foreach ($_POST['sizes_ml'] as $idx => $ml) {
            $s_price = floatval($_POST['sizes_price'][$idx]);
            $s_stock = intval($_POST['sizes_stock'][$idx]);
            $stmt_size->bind_param("iidi", $product_id, $ml, $s_price, $s_stock);
            $stmt_size->execute();
        }
    }

    // Handle gallery images
    if (isset($_POST['gallery']) && is_array($_POST['gallery'])) {
        $conn->query("DELETE FROM product_images WHERE product_id = $product_id");
        $stmt_img = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
        foreach ($_POST['gallery'] as $img_url) {
            if (!empty($img_url)) {
                $stmt_img->bind_param("is", $product_id, $img_url);
                $stmt_img->execute();
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving product: ' . $conn->error]);
}
?>
