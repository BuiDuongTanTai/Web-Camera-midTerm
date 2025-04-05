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

// Kiểm tra dữ liệu đầu vào
if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

// Xóa sản phẩm khỏi giỏ hàng
session_start();

if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$product_id])) {
    echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    exit;
}

unset($_SESSION['cart'][$product_id]);

// Trả về kết quả
echo json_encode([
    'success' => true,
    'cart_count' => isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0,
    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng'
]);
?>