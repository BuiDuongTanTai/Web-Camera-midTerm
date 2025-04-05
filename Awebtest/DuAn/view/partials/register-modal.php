<!-- Register Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Đăng ký tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo SITE_URL; ?>/register-process.php" method="post" id="register-form">
                    <div class="mb-3">
                        <label for="register-name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="register-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="register-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="register-phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="register-password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-confirm-password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="register-confirm-password" name="confirm_password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="agree-terms" name="agree_terms" required>
                        <label class="form-check-label" for="agree-terms">Tôi đồng ý với <a href="<?php echo SITE_URL; ?>/pages/terms.php">điều khoản sử dụng</a></label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="mb-0">Đã có tài khoản? <a href="#login-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>