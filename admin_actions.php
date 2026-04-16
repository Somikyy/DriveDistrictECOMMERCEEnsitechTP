<?php
require_once 'data.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';
$product_id = (int)($_POST['id'] ?? 0);

if ($action === 'save') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $desc = $_POST['desc'] ?? '';
    $image = $_POST['image'] ?? '';
    
    // Process sizes and colors (comma-separated to JSON)
    $sizes_raw = $_POST['sizes'] ?? '';
    $sizes = json_encode(array_map('trim', explode(',', $sizes_raw)));
    
    $colors_raw = $_POST['colors'] ?? '';
    $colors = json_encode(array_map('trim', explode(',', $colors_raw)));

    if ($product_id > 0) {
        // Update
        $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ?, stock = ?, sizes = ?, colors = ?, desc = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $category, $price, $stock, $sizes, $colors, $desc, $image, $product_id]);
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, sizes, colors, desc, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $category, $price, $stock, $sizes, $colors, $desc, $image]);
    }
} elseif ($action === 'delete') {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
}

header('Location: admin.php');
exit;
