<?php
function CheckLogin($email, $pass)
{
    $DBH = connect();
    $query = "
    SELECT * FROM admin
    WHERE email = :email
    ";

    $STH = $DBH->prepare($query);
    $STH->bindParam(':email', $email);
    $STH->execute();
    
    // Lấy thông tin người dùng
    $user = $STH->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem người dùng tồn tại và so sánh mật khẩu
    if ($user && password_verify($pass, $user['password'])) {
        return true; // Đăng nhập thành công
    }
    
    return false; // Đăng nhập thất bại
}
?>