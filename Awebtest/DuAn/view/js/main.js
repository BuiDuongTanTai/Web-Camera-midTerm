document.addEventListener('DOMContentLoaded', function() {
    // Xử lý thêm sản phẩm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    
    if(addToCartButtons) {
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.dataset.productId;
                const quantity = document.querySelector(`#quantity-${productId}`) ? 
                                document.querySelector(`#quantity-${productId}`).value : 1;
                
                fetch('controller/add-to-cart.php', { // Updated path
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&quantity=${quantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Cập nhật số lượng sản phẩm trong giỏ hàng
                        document.querySelector('.cart-count').textContent = data.cart_count;
                        
                        // Hiển thị thông báo thành công
                        alert('Sản phẩm đã được thêm vào giỏ hàng!');
                        
                        // Hiển thị modal giỏ hàng
                        const cartModal = new bootstrap.Modal(document.getElementById('cart-modal'));
                        cartModal.show();
                    } else {
                        alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
                });
            });
        });
    }
    
    // Xử lý cập nhật số lượng sản phẩm trong giỏ hàng
    const updateCartButtons = document.querySelectorAll('.update-cart');
    
    if(updateCartButtons) {
        updateCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const action = this.dataset.action;
                
                fetch('controller/update-cart.php', { // Updated path
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&action=${action}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Cập nhật lại nội dung modal giỏ hàng
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
                });
            });
        });
    }
    
    // Xử lý xóa sản phẩm khỏi giỏ hàng
    const removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
    
    if(removeFromCartButtons) {
        removeFromCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                
                fetch('controller/remove-from-cart.php', { // Updated path
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Cập nhật lại nội dung modal giỏ hàng
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng');
                });
            });
        });
    }
    
    // Xử lý xóa toàn bộ giỏ hàng
    const clearCartButton = document.querySelector('.clear-cart');
    
    if(clearCartButton) {
        clearCartButton.addEventListener('click', function() {
            fetch('controller/clear-cart.php', { // Updated path
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Cập nhật lại nội dung modal giỏ hàng
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra khi xóa giỏ hàng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa giỏ hàng');
            });
        });
    }
    
    // Hiển thị đếm ngược khuyến mãi
    function startCountdown() {
        const countdownElement = document.querySelector('.countdown');
        
        if(countdownElement) {
            // Thời gian kết thúc (ví dụ: 15 ngày từ hiện tại)
            const now = new Date();
            const endDate = new Date();
            endDate.setDate(now.getDate() + 15);
            
            // Cập nhật đếm ngược mỗi giây
            const countdownInterval = setInterval(function() {
                const now = new Date().getTime();
                const distance = endDate - now;
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Hiển thị kết quả
                document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
                document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
                
                // Nếu đếm ngược kết thúc
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    document.querySelector('.countdown').innerHTML = '<div class="alert alert-info">Khuyến mãi đã kết thúc!</div>';
                }
            }, 1000);
        }
    }
    
    startCountdown();
});