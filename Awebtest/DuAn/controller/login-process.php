<?php
require_once 'model/config.php'; // Updated path to config.php

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . SITE_URL);
    exit;
}

// Lấy thông tin đăng nhập
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember = isset($_POST['remember']) ? true : false;

// Kiểm tra dữ liệu đầu vào
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ email và mật khẩu';
    header('Location: ' . SITE_URL);
    exit;
}

// Kết nối đến database
$conn = connectDB(); // Ensure connectDB() is defined in functions.php

// Kiểm tra thông tin đăng nhập
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng';
    header('Location: ' . SITE_URL);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng';
    header('Location: ' . SITE_URL);
    exit;
}

// Đăng nhập thành công
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];

// Lưu cookie nếu người dùng chọn "Ghi nhớ đăng nhập"
if ($remember) {
    $token = bin2hex(random_bytes(32));
    $expires = time() + 30 * 24 * 60 * 60; // 30 days
    
    // Lưu token vào database
    $sql = "INSERT INTO user_tokens (user_id, token, expires) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $user['id'], $token, $expires);
    $stmt->execute();
    
    // Lưu token vào cookie
    setcookie('remember_token', $token, $expires, '/', '', true, true);
}

$stmt->close();
$conn->close();

// Chuyển hướng người dùng sau khi đăng nhập
header('Location: ' . SITE_URL);
exit;
?>