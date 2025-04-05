<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=cate">Danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=product">Sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=orders">Đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=users">Khách hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=comments">Bình luận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?act=statistics">Thống kê</a>
        </li>
        <?php if (isset($_SESSION["admin"])): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=logout">Đăng xuất: <?php echo $_SESSION["admin"]; ?></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>