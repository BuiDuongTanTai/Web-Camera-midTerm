<?php
require_once 'model/config.php'; // Updated path to config.php

// Xóa session
session_start();
$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

// Xóa cookie remember_token
if (isset($_COOKIE['remember_token'])) {
    // Kết nối đến database
    $conn = connectDB();
    
    // Xóa token khỏi database
    $token = $_COOKIE['remember_token'];
    $sql = "DELETE FROM user_tokens WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    // Xóa cookie
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
}

// Chuyển hướng về trang chủ
header('Location: ' . SITE_URL);
exit;
?>