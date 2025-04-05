<?php
require_once 'model/config.php'; // Updated path to config.php

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Lấy thông tin sản phẩm
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

// Kiểm tra dữ liệu đầu vào
if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity']);
    exit;
}

// Thêm vào giỏ hàng
$cart_count = addToCart($product_id, $quantity); // Ensure addToCart function is defined in functions.php

// Trả về kết quả
echo json_encode([
    'success' => true,
    'cart_count' => $cart_count,
    'message' => 'Sản phẩm đã được thêm vào giỏ hàng'
]);
?>