<?php
session_start();
include_once 'model/config.php';
include_once 'model/user.php';
include 'view/header.php';

$action = isset($_GET['act']) ? $_GET['act'] : 'home';

if (!isset($_SESSION['admin'])) {
    $action = 'login';
}

switch ($action) {
    case "home":
        include 'view/home.php';
        break;

    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_submit'])) {
            $email = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
            $pass = $_POST['password']; // Mật khẩu nên được xử lý an toàn hơn, có thể mã hóa

            // Kiểm tra đăng nhập
            if (CheckLogin($email, $pass)) {
                $_SESSION['admin'] = $email;
                header("Location: index.php");
                exit; // Dừng script sau khi redirect
            } else {
                $login_error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
                include 'view/login.php';
            }
        } else {
            include 'view/login.php';
        }
        break;

    case "logout":
        unset($_SESSION['admin']);
        header("Location: index.php");
        exit;

    case "cate":
        include 'view/catalog.php';
        break;

    case "product":
        include 'view/product.php';
        break;

    default:
        include 'view/home.php';
        break;
}

include 'view/footer.php';
?>