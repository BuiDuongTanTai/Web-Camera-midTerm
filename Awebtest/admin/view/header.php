<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <ul class="navbar-nav">
        <?php if (isset($_SESSION["admin"])): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=logout">Đăng xuất: <?php echo $_SESSION["admin"]; ?></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>