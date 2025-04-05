<?php
require_once 'model/config.php'; // Updated path to config.php

// Kiểm tra request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . SITE_URL);
    exit;
}

// Lấy email
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Kiểm tra dữ liệu đầu vào
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['newsletter_error'] = 'Email không hợp lệ';
    header('Location: ' . SITE_URL);
    exit;
}

// Kết nối đến database
$conn = connectDB();

// Kiểm tra email đã đăng ký chưa
$sql = "SELECT * FROM newsletter_subscribers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['newsletter_message'] = 'Email của bạn đã được đăng ký trước đó';
    header('Location: ' . SITE_URL);
    exit;
}

// Thêm email vào danh sách
$sql = "INSERT INTO newsletter_subscribers (email, created_at) VALUES (?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

// Kiểm tra kết quả
if ($stmt->affected_rows <= 0) {
    $_SESSION['newsletter_error'] = 'Đăng ký thất bại, vui lòng thử lại sau';
    header('Location: ' . SITE_URL);
    exit;
}

$stmt->close();
$conn->close();

// Hiển thị thông báo thành công
$_SESSION['newsletter_message'] = 'Cảm ơn bạn đã đăng ký nhận thông tin từ CameraVN';
header('Location: ' . SITE_URL);
exit;
?>