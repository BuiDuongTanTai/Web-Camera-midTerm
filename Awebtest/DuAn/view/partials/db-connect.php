<?php
require_once 'model/config.php';

// Hàm tạo kết nối đến cơ sở dữ liệu
function connectDB() {
    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    // Thiết lập charset
    $conn->set_charset("utf8");
    
    return $conn;
}

// Hàm kiểm tra xem cơ sở dữ liệu có tồn tại hay không
function checkDatabaseExists($conn, $dbName) {
    $result = $conn->query("SHOW DATABASES LIKE '$dbName'");
    return $result->num_rows > 0;
}

// Sử dụng hàm để kiểm tra
$conn = connectDB();
if (!checkDatabaseExists($conn, DB_NAME)) {
    die("Cơ sở dữ liệu không tồn tại: " . DB_NAME);
}

// Nếu cơ sở dữ liệu tồn tại, có thể thực hiện các truy vấn tiếp theo
echo "Cơ sở dữ liệu $dbName đã được tìm thấy.";
?>