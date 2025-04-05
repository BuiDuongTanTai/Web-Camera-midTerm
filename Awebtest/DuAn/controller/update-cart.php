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
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Kiểm tra dữ liệu đầu vào
if ($product_id <= 0 || !in_array($action, ['increase', 'decrease'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID or action']);
    exit;
}

// Cập nhật giỏ hàng
session_start();

if (!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$product_id])) {
    echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    exit;
}

if ($action === 'increase') {
    $_SESSION['cart'][$product_id]++;
} else {
    if ($_SESSION['cart'][$product_id] > 1) {
        $_SESSION['cart'][$product_id]--;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Trả về kết quả
echo json_encode([
    'success' => true,
    'cart_count' => array_sum($_SESSION['cart']),
    'message' => 'Giỏ hàng đã được cập nhật'
]);
?>