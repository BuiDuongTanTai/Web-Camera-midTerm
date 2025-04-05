
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5><?php echo SITE_NAME; ?></h5>
                <p class="text-muted">Hệ thống cung cấp giải pháp camera toàn diện với đa dạng sản phẩm chất lượng cao.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5>Thông tin</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo SITE_URL; ?>/pages/about.php">Về chúng tôi</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/blog.php">Tin tức & Sự kiện</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/careers.php">Tuyển dụng</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/stores.php">Hệ thống cửa hàng</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5>Dịch vụ khách hàng</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo SITE_URL; ?>/pages/contact.php">Liên hệ</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/faq.php">Câu hỏi thường gặp</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/warranty.php">Chính sách bảo hành</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/returns.php">Chính sách đổi trả</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/shipping.php">Thông tin vận chuyển</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5>Liên hệ</h5>
                <ul class="list-unstyled">
                    <li><i class="bi bi-geo-alt me-2"></i> <?php echo COMPANY_ADDRESS; ?></li>
                    <li><i class="bi bi-telephone me-2"></i> <?php echo COMPANY_PHONE; ?></li>
                    <li><i class="bi bi-envelope me-2"></i> <?php echo COMPANY_EMAIL; ?></li>
                    <li><i class="bi bi-clock me-2"></i> <?php echo COMPANY_HOURS; ?></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <p class="mb-0">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Tất cả các quyền được bảo lưu.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='250' height='30' viewBox='0 0 250 30'><rect x='10' y='5' width='40' height='20' rx='3' fill='%23adb5bd'/><rect x='60' y='5' width='40' height='20' rx='3' fill='%23adb5bd'/><rect x='110' y='5' width='40' height='20' rx='3' fill='%23adb5bd'/><rect x='160' y='5' width='40' height='20' rx='3' fill='%23adb5bd'/><rect x='210' y='5' width='30' height='20' rx='3' fill='%23adb5bd'/></svg>" alt="Payment Methods" class="img-fluid">
            </div>
        </div>
    </div>
</footer>

<?php include 'includes/cart-modal.php'; ?>
<?php include 'includes/login-modal.php'; ?>
<?php include 'includes/register-modal.php'; ?>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>