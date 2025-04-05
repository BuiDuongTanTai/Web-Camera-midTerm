<?php
require_once 'model/config.php'; // Updated path to config.php

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . SITE_URL);
    exit;
}

// Lấy thông tin đăng ký
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$agree_terms = isset($_POST['agree_terms']) ? true : false;

// Kiểm tra dữ liệu đầu vào
$errors = [];

if (empty($name)) {
    $errors[] = 'Vui lòng nhập họ tên';
}

if (empty($email)) {
    $errors[] = 'Vui lòng nhập email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

if (empty($phone)) {
    $errors[] = 'Vui lòng nhập số điện thoại';
}

if (empty($password)) {
    $errors[] = 'Vui lòng nhập mật khẩu';
} elseif (strlen($password) < 6) {
    $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
}

if ($password !== $confirm_password) {
    $errors[] = 'Xác nhận mật khẩu không khớp';
}

if (!$agree_terms) {
    $errors[] = 'Bạn phải đồng ý với điều khoản sử dụng';
}

if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    header('Location: ' . SITE_URL);
    exit;
}

// Kết nối đến database
$conn = connectDB();

// Kiểm tra email đã tồn tại chưa
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['register_errors'] = ['Email đã được sử dụng'];
    header('Location: ' . SITE_URL);
    exit;
}

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Thêm người dùng mới vào database
$sql = "INSERT INTO users (name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
$stmt->execute();

// Kiểm tra kết quả
if ($stmt->affected_rows <= 0) {
    $_SESSION['register_errors'] = ['Đăng ký thất bại, vui lòng thử lại sau'];
    header('Location: ' . SITE_URL);
    exit;
}

// Lưu thông tin đăng nhập
$user_id = $stmt->insert_id;
session_start();
$_SESSION['user_id'] = $user_id;
$_SESSION['user_name'] = $name;
$_SESSION['user_email'] = $email;

$stmt->close();
$conn->close();

// Chuyển hướng người dùng sau khi đăng ký
header('Location: ' . SITE_URL);
exit;
?>