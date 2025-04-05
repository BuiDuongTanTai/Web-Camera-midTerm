<?php
require_once 'view/partials/db-connect.php';

// Lấy danh sách sản phẩm nổi bật
function getFeaturedProducts($limit = 6) {
    $conn = connectDB();
    $sql = "SELECT * FROM products WHERE featured = 1 LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $products;
}

// Lấy danh sách danh mục
function getCategories() {
    $conn = connectDB();
    $sql = "SELECT * FROM categories ORDER BY name";
    $result = $conn->query($sql);
    
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    
    $conn->close();
    
    return $categories;
}

// Lấy danh sách đánh giá từ khách hàng
function getTestimonials($limit = 3) {
    $conn = connectDB();
    $sql = "SELECT * FROM testimonials ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $testimonials = [];
    while ($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $testimonials;
}

// Hàm xử lý thêm vào giỏ hàng
function addToCart($product_id, $quantity = 1) {
    session_start();
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if(isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    return count($_SESSION['cart']);
}

// Hàm lấy số lượng sản phẩm trong giỏ hàng
function getCartCount() {
    session_start();
    
    if(!isset($_SESSION['cart'])) {
        return 0;
    }
    
    return array_sum($_SESSION['cart']);
}

// Hàm lấy chi tiết giỏ hàng
function getCartDetails() {
    session_start();
    
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return [];
    }
    
    $conn = connectDB();
    $cart = [];
    $total = 0;
    
    foreach($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($product = $result->fetch_assoc()) {
            $item_total = $product['sale_price'] > 0 ? $product['sale_price'] * $quantity : $product['price'] * $quantity;
            $cart[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['sale_price'] > 0 ? $product['sale_price'] : $product['price'],
                'original_price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity,
                'total' => $item_total
            ];
            $total += $item_total;
        }
        
        $stmt->close();
    }
    
    $conn->close();
    
    return [
        'items' => $cart,
        'total' => $total
    ];
}
?>