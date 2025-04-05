<?php
// Thiết lập trang hiện tại
$active_page = 'products';
$page_title = 'Sản phẩm';

// Kết nối đến file functions.php để sử dụng các hàm
require_once '../includes/functions.php';

// Xử lý lọc và tìm kiếm
$category_id = isset($_GET['category']) ? $_GET['category'] : null;
$search_term = isset($_GET['search']) ? $_GET['search'] : null;
$promotion = isset($_GET['promotion']) ? $_GET['promotion'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'featured';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 12; // Số sản phẩm trên mỗi trang

// Lấy danh sách sản phẩm theo bộ lọc
function getProducts($category_id = null, $search_term = null, $promotion = null, $sort = 'featured', $page = 1, $limit = 12) {
    $conn = connectDB();
    
    $offset = ($page - 1) * $limit;
    
    // Xây dựng câu truy vấn cơ bản
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];
    $types = "";
    
    // Thêm điều kiện filter
    if ($category_id) {
        $sql .= " AND category_id = ?";
        $params[] = $category_id;
        $types .= "i";
    }
    
    if ($search_term) {
        $sql .= " AND (name LIKE ? OR description LIKE ?)";
        $search_param = "%{$search_term}%";
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= "ss";
    }
    
    if ($promotion) {
        $sql .= " AND sale_price > 0";
    }
    
    // Thêm sắp xếp
    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC";
            break;
        case 'newest':
            $sql .= " ORDER BY created_at DESC";
            break;
        case 'bestseller':
            $sql .= " ORDER BY sold DESC";
            break;
        case 'rating':
            $sql .= " ORDER BY rating DESC";
            break;
        default:
            $sql .= " ORDER BY featured DESC, id DESC";
    }
    
    // Thêm giới hạn và phân trang
    $sql .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $limit;
    $types .= "ii";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    // Đếm tổng số sản phẩm
    $count_sql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
    $count_params = [];
    $count_types = "";
    
    if ($category_id) {
        $count_sql .= " AND category_id = ?";
        $count_params[] = $category_id;
        $count_types .= "i";
    }
    
    if ($search_term) {
        $count_sql .= " AND (name LIKE ? OR description LIKE ?)";
        $count_param = "%{$search_term}%";
        $count_params[] = $count_param;
        $count_params[] = $count_param;
        $count_types .= "ss";
    }
    
    if ($promotion) {
        $count_sql .= " AND sale_price > 0";
    }
    
    $count_stmt = $conn->prepare($count_sql);
    
    if (!empty($count_params)) {
        $count_stmt->bind_param($count_types, ...$count_params);
    }
    
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
    $total_products = $count_row['total'];
    
    $stmt->close();
    $count_stmt->close();
    $conn->close();
    
    return [
        'products' => $products,
        'total' => $total_products,
        'pages' => ceil($total_products / $limit)
    ];
}

// Lấy danh sách sản phẩm
$products_data = getProducts($category_id, $search_term, $promotion, $sort, $page, $limit);
$products = $products_data['products'];
$total_products = $products_data['total'];
$total_pages = $products_data['pages'];

// Lấy danh sách danh mục
$categories = getCategories();

// Lấy thông tin danh mục hiện tại nếu có
$current_category = null;
if ($category_id) {
    foreach ($categories as $category) {
        if ($category['id'] == $category_id) {
            $current_category = $category;
            break;
        }
    }
}

// Bao gồm header
include '../includes/header.php';
?>

<!-- Breadcrumb -->
<section class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $current_category ? htmlspecialchars($current_category['name']) : 'Tất cả sản phẩm'; ?>
            </li>
        </ol>
    </nav>
</section>

<!-- Page Title -->
<section class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">
            <?php 
            if ($search_term) {
                echo 'Kết quả tìm kiếm: "' . htmlspecialchars($search_term) . '"';
            } elseif ($promotion) {
                echo 'Sản phẩm khuyến mãi';
            } elseif ($current_category) {
                echo htmlspecialchars($current_category['name']);
            } else {
                echo 'Tất cả sản phẩm';
            }
            ?>
        </h1>
        <div class="text-muted">Hiển thị <?php echo count($products); ?> trên <?php echo $total_products; ?> sản phẩm</div>
    </div>
</section>

<!-- Products List with Filters -->
<section class="container mb-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Danh mục sản phẩm</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0">
                            <a href="<?php echo SITE_URL; ?>/pages/products.php" class="text-decoration-none <?php echo !$category_id ? 'fw-bold text-primary' : 'text-dark'; ?>">
                                Tất cả sản phẩm
                            </a>
                        </li>
                        <?php foreach ($categories as $category): ?>
                        <li class="list-group-item border-0 px-0">
                            <a href="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category['id']; ?>"
                            class="text-decoration-none <?php echo $category_id == $category['id'] ? 'fw-bold text-primary' : 'text-dark'; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <hr>
                    
                    <h5 class="mb-3">Giá</h5>
                    <form action="<?php echo SITE_URL; ?>/pages/products.php" method="get">
                        <?php if ($category_id): ?>
                        <input type="hidden" name="category" value="<?php echo $category_id; ?>">
                        <?php endif; ?>
                        <?php if ($search_term): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_term); ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <select class="form-select" name="price_range" id="price_range">
                                <option value="">Tất cả giá</option>
                                <option value="0-1000000">Dưới 1.000.000đ</option>
                                <option value="1000000-2000000">1.000.000đ - 2.000.000đ</option>
                                <option value="2000000-5000000">2.000.000đ - 5.000.000đ</option>
                                <option value="5000000-10000000">5.000.000đ - 10.000.000đ</option>
                                <option value="10000000-0">Trên 10.000.000đ</option>
                            </select>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Trạng thái</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="in_stock">
                            <label class="form-check-label" for="in_stock">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="on_sale" value="1" id="on_sale" <?php echo $promotion ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="on_sale">
                                Đang giảm giá
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mt-3">Lọc sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sorting Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <label for="sort_by" class="me-2">Sắp xếp theo:</label>
                    <select class="form-select d-inline-block w-auto" id="sort_by" onchange="location = this.value;">
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=featured" <?php echo $sort == 'featured' ? 'selected' : ''; ?>>Nổi bật</option>
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=price_asc" <?php echo $sort == 'price_asc' ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=price_desc" <?php echo $sort == 'price_desc' ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=bestseller" <?php echo $sort == 'bestseller' ? 'selected' : ''; ?>>Bán chạy nhất</option>
                        <option value="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=rating" <?php echo $sort == 'rating' ? 'selected' : ''; ?>>Đánh giá cao nhất</option>
                    </select>
                </div>
                
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active"><i class="bi bi-grid-3x3-gap"></i></button>
                    <button type="button" class="btn btn-outline-secondary"><i class="bi bi-list"></i></button>
                </div>
            </div>
            
            <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="bi bi-exclamation-circle text-muted" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Không tìm thấy sản phẩm</h3>
                <p class="text-muted">Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                <a href="<?php echo SITE_URL; ?>/pages/products.php" class="btn btn-primary mt-3">Xem tất cả sản phẩm</a>
            </div>
            <?php else: ?>
            <!-- Products -->
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card product-card h-100">
                        <?php if ($product['discount'] > 0): ?>
                        <span class="badge bg-danger badge-sale">-<?php echo $product['discount']; ?>%</span>
                        <?php endif; ?>
                        <div class="product-image" id="product-<?php echo $product['id']; ?>"></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <div>
                                    <span class="badge bg-success"><?php echo number_format($product['rating'], 1); ?> <i class="bi bi-star-fill"></i></span>
                                </div>
                            </div>
                            <p class="mb-1">
                                <?php if ($product['sale_price'] > 0): ?>
                                <span class="text-decoration-line-through text-muted me-2"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                <span class="text-danger fw-bold"><?php echo number_format($product['sale_price'], 0, ',', '.'); ?>đ</span>
                                <?php else: ?>
                                <span class="text-danger fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><?php echo htmlspecialchars($product['short_description']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="badge <?php echo $product['stock'] > 10 ? 'bg-primary' : ($product['stock'] > 0 ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                    <?php 
                                    if ($product['stock'] > 10) {
                                        echo 'Còn hàng';
                                    } elseif ($product['stock'] > 0) {
                                        echo 'Sắp hết hàng';
                                    } else {
                                        echo 'Hết hàng';
                                    }
                                    ?>
                                </div>
                                <small class="text-muted">Đã bán: <?php echo $product['sold']; ?></small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                            <button class="btn btn-outline-primary"><i class="bi bi-heart"></i></button>
                            <a href="#" class="btn btn-primary btn-add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                                <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=<?php echo $sort; ?>&page=<?php echo $page - 1; ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=<?php echo $sort; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo SITE_URL; ?>/pages/products.php?category=<?php echo $category_id; ?>&search=<?php echo urlencode($search_term); ?>&promotion=<?php echo $promotion; ?>&sort=<?php echo $sort; ?>&page=<?php echo $page + 1; ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>