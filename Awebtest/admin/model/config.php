<?php
function connect()
{
    $host = "localhost";
    $dbname = "camera_store_dump";
    $username = "root";
    $password = "";
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
        // Tạo kết nối PDO
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, $options);
        return $DBH;
    } catch (PDOException $e) {
        // Xử lý lỗi kết nối
        echo "Connection failed: " . $e->getMessage();
        exit; // Dừng chương trình nếu không thể kết nối
    }
}
?>