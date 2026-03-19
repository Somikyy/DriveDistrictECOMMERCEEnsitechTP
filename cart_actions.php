<?php
require_once 'data.php';

$action = $_POST['action'] ?? '';
$product_id = (int)($_POST['product_id'] ?? 0);
$size = trim($_POST['size'] ?? '');
$redirect = $_POST['redirect'] ?? 'catalogue.php';

if ($action === 'add' && isset($products[$product_id])) {
    $key = $product_id . '_' . $size;
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['qty']++;
    } else {
        $_SESSION['cart'][$key] = [
            'product_id' => $product_id,
            'size' => $size,
            'qty' => 1,
        ];
    }
} elseif ($action === 'remove') {
    $key = $_POST['key'] ?? '';
    unset($_SESSION['cart'][$key]);
    $redirect = 'cart.php';
} elseif ($action === 'clear') {
    $_SESSION['cart'] = [];
    $redirect = 'payment.php?success=1';
}

header("Location: $redirect");
exit;
