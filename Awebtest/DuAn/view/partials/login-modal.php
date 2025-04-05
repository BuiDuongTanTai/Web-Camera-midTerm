<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo SITE_URL; ?>/login-process.php" method="post" id="login-form">
                    <div class="mb-3">
                        <label for="login-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="login-password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="login-password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember-me" name="remember">
                        <label class="form-check-label" for="remember-me">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?php echo SITE_URL; ?>/pages/forgot-password.php" class="text-decoration-none">Quên mật khẩu?</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="mb-0">Chưa có tài khoản? <a href="#register-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</div>