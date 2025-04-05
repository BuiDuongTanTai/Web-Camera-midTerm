<?php
require_once 'model/config.php';
require_once 'view/partials/functions.php';
// Lấy số lượng sản phẩm trong giỏ hàng
$cart_count = getCartCount();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' . SITE_NAME : SITE_NAME . ' - Hệ thống camera chất lượng cao'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand logo" href="<?php echo SITE_URL; ?>"><i class="bi bi-camera-fill me-2"></i><?php echo SITE_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_page == 'home' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo $active_page == 'products' ? 'active' : ''; ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            $categories = getCategories();
                            foreach($categories as $category) {
                                echo '<li><a class="dropdown-item" href="' . SITE_URL . '/pages/products.php?category=' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a></li>';
                            }
                            ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/products.php?category=accessories">Phụ kiện</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_page == 'services' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/pages/services.php">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_page == 'about' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/pages/about.php">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_page == 'blog' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/pages/blog.php">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active_page == 'contact' ? 'active' : ''; ?>" href="<?php echo SITE_URL; ?>/pages/contact.php">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <form class="d-flex me-2" action="<?php echo SITE_URL; ?>/pages/products.php" method="get">
                        <div class="input-group">
                            <input class="form-control" type="search" name="search" placeholder="Tìm kiếm" aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <div class="position-relative me-2">
                        <a class="btn btn-outline-primary" href="#cart-modal" data-bs-toggle="modal">
                            <i class="bi bi-cart"></i>
                        </a>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/profile.php">Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/orders.php">Đơn hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/logout.php">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <a class="btn btn-outline-primary me-2" href="#login-modal" data-bs-toggle="modal"><i class="bi bi-person"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>