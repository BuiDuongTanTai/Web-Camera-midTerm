<?php
// Thiết lập trang hiện tại
$active_page = 'home';
$page_title = 'Trang chủ';

// Kết nối đến file functions.php để sử dụng các hàm
require_once 'view/partials/functions.php'; // Corrected 'paritals' to 'partials'

// Lấy danh sách sản phẩm nổi bật
$featured_products = getFeaturedProducts();
// Lấy danh sách danh mục
$categories = getCategories();
// Lấy danh sách đánh giá từ khách hàng
$testimonials = getTestimonials();
// Bao gồm header
include 'view/partials/header.php'; // Corrected 'paritals' to 'partials'
?>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 hero-title">Giải pháp camera</h1>
                <p class="lead mb-4">Bảo vệ gia đình và doanh nghiệp của bạn với hệ thống camera chất lượng cao, độ phân giải 4K và công nghệ AI tiên tiến.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="#products" class="btn btn-light btn-lg px-4 shadow-sm">Mua ngay</a>
                    <a href="<?php echo SITE_URL; ?>/pages/services.php" class="btn btn-outline-light btn-lg px-4">Dịch vụ lắp đặt</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='500' height='300' viewBox='0 0 500 300'><rect width='500' height='300' fill='transparent'/><rect x='150' y='50' width='200' height='120' rx='10' fill='white' opacity='0.1'/><circle cx='250' cy='110' r='40' fill='white' opacity='0.2'/><circle cx='250' cy='110' r='20' fill='white' opacity='0.3'/><circle cx='275' cy='85' r='5' fill='white' opacity='0.5'/></svg>" alt="Camera Illustration" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Category Section -->
<section class="container my-5">
    <h2 class="text-center mb-4">Danh mục sản phẩm</h2>
    <div class="row g-4">
        <?php foreach($categories as $category): ?>
        <div class="col-6 col-md-4 col-lg-2">
            <a href="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category['id']; ?>" class="text-decoration-none">
                <div class="card category-card text-center h-100 shadow-sm">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="bi <?php echo $category['icon']; ?>"></i>
                        </div>
                        <h6 class="card-title"><?php echo $category['name']; ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Features Section -->
<section class="bg-light py-5 mb-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-truck text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">Giao hàng miễn phí</h5>
                        <p class="mb-0 text-muted">Cho đơn hàng từ 2 triệu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-shield-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">Bảo hành chính hãng</h5>
                        <p class="mb-0 text-muted">Lên đến 24 tháng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-tools text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">Dịch vụ lắp đặt</h5>
                        <p class="mb-0 text-muted">Chuyên nghiệp, tận nơi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="container" id="products">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sản phẩm nổi bật</h2>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary active">Tất cả</button>
            <?php foreach(array_slice($categories, 0, 3) as $category): ?>
            <button type="button" class="btn btn-outline-primary"><?php echo $category['name']; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row g-4">
        <?php foreach($featured_products as $product): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card h-100">
                <?php if($product['discount'] > 0): ?>
                <span class="badge bg-danger badge-sale">-<?php echo $product['discount']; ?>%</span>
                <?php endif; ?>
                <div class="product-image" id="product-<?php echo $product['id']; ?>"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <div>
                            <span class="badge bg-success"><?php echo number_format($product['rating'], 1); ?> <i class="bi bi-star-fill"></i></span>
                        </div>
                    </div>
                    <p class="mb-1">
                        <?php if($product['sale_price'] > 0): ?>
                        <span class="text-decoration-line-through text-muted me-2"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                        <span class="text-danger fw-bold"><?php echo number_format($product['sale_price'], 0, ',', '.'); ?>đ</span>
                        <?php else: ?>
                        <span class="text-danger fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                        <?php endif; ?>
                    </p>
                    <p class="card-text"><?php echo $product['short_description']; ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="badge <?php echo $product['stock'] > 10 ? 'bg-primary' : 'bg-warning text-dark'; ?>">
                            <?php echo $product['stock'] > 10 ? 'Còn hàng' : 'Sắp hết hàng'; ?>
                        </div>
                        <small class="text-muted">Đã bán: <?php echo $product['sold']; ?></small>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                    <button class="btn btn-outline-primary"><i class="bi bi-heart"></i></button>
                    <a href="#" class="btn btn-primary btn-add-to-cart" data-product-id="<?php echo $product['id']; ?>"><i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
        <a href="<?php echo SITE_URL; ?>/pages/products.php" class="btn btn-outline-primary">Xem thêm sản phẩm <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

<!-- Promotion Banner -->
<section class="container my-5">
    <div class="card border-0 bg-dark text-white">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-3">Khuyến mãi đặc biệt tháng 3</h2>
                    <p class="lead">Giảm đến 30% cho tất cả camera thông minh và miễn phí lắp đặt cho đơn hàng từ 5 triệu.</p>
                    <div class="mt-4 countdown">
                        <div class="row g-2">
                            <div class="col-3">
                                <div class="bg-primary rounded p-3 text-center">
                                    <div class="h3 mb-0" id="countdown-days">15</div>
                                    <small>Ngày</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="bg-primary rounded p-3 text-center">
                                    <div class="h3 mb-0" id="countdown-hours">08</div>
                                    <small>Giờ</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="bg-primary rounded p-3 text-center">
                                    <div class="h3 mb-0" id="countdown-minutes">45</div>
                                    <small>Phút</small>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="bg-primary rounded p-3 text-center">
                                    <div class="h3 mb-0" id="countdown-seconds">20</div>
                                    <small>Giây</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo SITE_URL; ?>/pages/products.php?promotion=1" class="btn btn-primary">Mua ngay</a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'><rect width='300' height='300' fill='transparent'/><circle cx='150' cy='150' r='80' fill='white' opacity='0.1'/><circle cx='150' cy='150' r='60' fill='white' opacity='0.15'/><circle cx='150' cy='150' r='40' fill='white' opacity='0.2'/><circle cx='180' cy='120' r='7' fill='white' opacity='0.5'/></svg>" alt="Camera Promo" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="container my-5" id="services">
    <h2 class="text-center mb-5">Dịch vụ của chúng tôi</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary p-3 d-inline-flex mb-3">
                        <i class="bi bi-tools text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">Lắp đặt chuyên nghiệp</h5>
                    <p class="card-text">Đội ngũ kỹ thuật viên có chuyên môn cao, nhiều năm kinh nghiệm lắp đặt camera an ninh.</p>
                    <a href="<?php echo SITE_URL; ?>/pages/services.php#installation" class="btn btn-outline-primary mt-3">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary p-3 d-inline-flex mb-3">
                        <i class="bi bi-headset text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">Tư vấn giải pháp</h5>
                    <p class="card-text">Tư vấn và thiết kế hệ thống camera giám sát phù hợp với nhu cầu và ngân sách của khách hàng.</p>
                    <a href="<?php echo SITE_URL; ?>/pages/services.php#consulting" class="btn btn-outline-primary mt-3">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary p-3 d-inline-flex mb-3">
                        <i class="bi bi-shield-check text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title">Bảo trì & Bảo dưỡng</h5>
                    <p class="card-text">Dịch vụ bảo trì, bảo dưỡng định kỳ và sửa chữa nhanh chóng khi có sự cố.</p>
                    <a href="<?php echo SITE_URL; ?>/pages/services.php#maintenance" class="btn btn-outline-primary mt-3">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-light py-5 my-5">
    <div class="container">
        <h2 class="text-center mb-5">Khách hàng nói gì về chúng tôi</h2>
        <div class="row g-4">
            <?php foreach($testimonials as $testimonial): ?>
            <div class="col-md-4">
                <div class="card testimonial-card h-100 shadow-sm">
                    <div class="card-body p-4">
                        <div class="testimonial-avatar">
                            <?php 
                            $initials = '';
                            $name_parts = explode(' ', $testimonial['name']);
                            foreach(array_slice($name_parts, -2, 2) as $part) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                            echo $initials;
                            ?>
                        </div>
                        <div class="text-center mb-3">
                            <div class="text-warning">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= floor($testimonial['rating'])): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php elseif($i - 0.5 <= $testimonial['rating']): ?>
                                        <i class="bi bi-star-half"></i>
                                    <?php else: ?>
                                        <i class="bi bi-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p class="card-text">"<?php echo $testimonial['comment']; ?>"</p>
                        <p class="text-end mb-0 fw-bold"><?php echo $testimonial['name']; ?></p>
                        <p class="text-end text-muted small"><?php echo $testimonial['title']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-3">Đăng ký nhận thông tin</h2>
                <p class="lead mb-4">Nhận thông tin về khuyến mãi, sản phẩm mới và các mẹo hữu ích về an ninh.</p>
                <form class="row g-3 justify-content-center" method="post" action="<?php echo SITE_URL; ?>/newsletter-subscribe.php">
                    <div class="col-md-8">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email của bạn" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-light btn-lg w-100">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// Bao gồm footer
include 'view/partials/footer.php'; // Corrected 'paritals' to 'partials'
?>