<?php
require_once 'model/config.php'; // Updated path to config.php

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Xóa toàn bộ giỏ hàng
session_start();
unset($_SESSION['cart']);

// Trả về kết quả
echo json_encode([
    'success' => true,
    'message' => 'Giỏ hàng đã được xóa'
]);
?>