<div class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-4">Trang quản trị CameraVN</h1>
        <p class="lead">Đây là trang quản trị của cửa hàng máy ảnh CameraVN. Quản lý danh mục sản phẩm, sản phẩm, đơn hàng, khách hàng và các chức năng khác.</p>
        <hr class="my-4">
        <p>Sử dụng menu phía trên để truy cập các chức năng quản trị.</p>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text display-4">
                        <?php
                        $DBH = connect();
                        $stmt = $DBH->query("SELECT COUNT(*) FROM products");
                        echo $stmt->fetchColumn();
                        ?>
                    </p>
                    <a href="index.php?act=product" class="btn btn-light">Quản lý</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Đơn hàng</h5>
                    <p class="card-text display-4">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM orders");
                        echo $stmt->fetchColumn();
                        ?>
                    </p>
                    <a href="index.php?act=orders" class="btn btn-light">Quản lý</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Khách hàng</h5>
                    <p class="card-text display-4">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM users");
                        echo $stmt->fetchColumn();
                        ?>
                    </p>
                    <a href="index.php?act=users" class="btn btn-light">Quản lý</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Bình luận</h5>
                    <p class="card-text display-4">
                        <?php
                        $stmt = $DBH->query("SELECT COUNT(*) FROM comments");
                        echo $stmt->fetchColumn();
                        ?>
                    </p>
                    <a href="index.php?act=comments" class="btn btn-light">Quản lý</a>
                </div>
            </div>
        </div>
    </div>
</div>