document.addEventListener('DOMContentLoaded', function() {
    // Loader
    const loader = document.querySelector('.loader-wrapper');
    setTimeout(() => {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }, 1000);
    
    // Khởi tạo AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Dark Mode Toggle
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';

        const tables = document.querySelectorAll('.table');
        tables.forEach(table => table.classList.add('table-dark'));
    }
    
    themeToggle.addEventListener('click', function() {
        document.body.classList.toggle('dark-theme');
        const tables = document.querySelectorAll('.table');

        if (document.body.classList.contains('dark-theme')) {
            localStorage.setItem('theme', 'dark');
            themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';
            tables.forEach(table => table.classList.add('table-dark'));
        } else {
            localStorage.setItem('theme', 'light');
            themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
            tables.forEach(table => table.classList.remove('table-dark'));
        }
    });
    
    // FancyBox Initialization
    Fancybox.bind('[data-fancybox]', {
        // Your custom options
    });
    
    // Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.hero-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.hero-swiper .swiper-button-next',
            prevEl: '.hero-swiper .swiper-button-prev',
        },
    });
    
    // Testimonial Swiper
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.testimonial-swiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
    
    // Back to Top Button
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('active');
        } else {
            backToTopButton.classList.remove('active');
        }
    });
    
    backToTopButton.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Scroll to Top Function
    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
    
    // Countdown Timer
    function updateCountdown() {
        // Set the date we're counting down to (16 days from now)
        const countDownDate = new Date();
        countDownDate.setDate(countDownDate.getDate() + 16);
        
        // Update the count down every 1 second
        const x = setInterval(function() {
            // Get today's date and time
            const now = new Date().getTime();
            
            // Find the distance between now and the count down date
            const distance = countDownDate - now;
            
            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result
            const daysElement = document.getElementById("days");
            const hoursElement = document.getElementById("hours");
            const minutesElement = document.getElementById("minutes");
            const secondsElement = document.getElementById("seconds");
            
            if (daysElement && hoursElement && minutesElement && secondsElement) {
                daysElement.innerHTML = days.toString().padStart(2, '0');
                hoursElement.innerHTML = hours.toString().padStart(2, '0');
                minutesElement.innerHTML = minutes.toString().padStart(2, '0');
                secondsElement.innerHTML = seconds.toString().padStart(2, '0');
                
                if (distance < 0) {
                    clearInterval(x);
                    daysElement.innerHTML = "00";
                    hoursElement.innerHTML = "00";
                    minutesElement.innerHTML = "00";
                    secondsElement.innerHTML = "00";
                }
            }
        }, 1000);
    }
    
    updateCountdown();
    
    // Dummy function for toast (replaced with empty function)
    function showToast(message, type = 'info') {
        // Không làm gì - đã xóa toast
        console.log(message); // Chỉ ghi log cho mục đích debug
    }
    
    // Cart Logic
    let cart = [];
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout');
    const cartCountElement = document.querySelector('.cart-count');
    let isLoggedIn = false; // Biến kiểm tra trạng thái đăng nhập
    
    // Sản phẩm mẫu
    const products = [
        {
            id: 1,
            name: "Canon EOS 850D",
            description: "Máy ảnh DSLR Canon EOS 850D kèm Lens Kit 18-55mm, 24.1MP, 4K, Wi-Fi, Bluetooth.",
            price: 19490000,
            oldPrice: 22990000,
            image: "figmaframe/hero.jpg",
            rating: 4.8,
            sold: 76,
            brand: "canon"
        },
        {
            id: 2,
            name: "Sony Alpha A7 IV",
            description: "Máy ảnh Sony Alpha A7 IV Mirrorless Full-frame, 33MP, 4K60p, 10fps, Eye-AF.",
            price: 55990000,
            image: "figmaframe/hero.jpg",
            rating: 4.9,
            sold: 42,
            brand: "sony"
        },
        {
            id: 3,
            name: "Nikon Z6 II",
            description: "Máy ảnh Nikon Z6 II Mirrorless Full-frame, 24.5MP, 4K, Wi-Fi, IBIS.",
            price: 38990000,
            oldPrice: 48990000,
            image: "figmaframe/hero.jpg",
            rating: 4.7,
            sold: 38,
            brand: "nikon"
        },
        {
            id: 4,
            name: "Fujifilm X-T4",
            description: "Máy ảnh Fujifilm X-T4 Mirrorless, 26.1MP, 4K60p, chống rung IBIS 5 trục.",
            price: 42990000,
            image: "figmaframe/hero.jpg",
            rating: 4.9,
            sold: 56,
            brand: "fuji"
        },
        {
            id: 5,
            name: "Canon RF 24-70mm f/2.8L",
            description: "Ống kính Canon RF 24-70mm f/2.8L IS USM cho máy ảnh mirrorless full-frame.",
            price: 59990000,
            image: "figmaframe/hero.jpg",
            rating: 4.8,
            sold: 32,
            brand: "canon"
        },
        {
            id: 6,
            name: "Sony ZV-E10",
            description: "Máy ảnh Sony ZV-E10 dành cho Vlog, APS-C, 24.2MP, 4K, màn hình xoay.",
            price: 17990000,
            oldPrice: 19990000,
            image: "figmaframe/hero.jpg",
            rating: 4.7,
            sold: 87,
            brand: "sony"
        }
    ];
    
    // Cập nhật số lượng hiển thị trên icon giỏ hàng
    function updateCartCount() {
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        cartCountElement.textContent = totalItems;
    }
    
    // Cập nhật hiển thị giỏ hàng
    function updateCart() {
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = '';
        let totalPrice = 0;
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<tr id="empty-cart"><td colspan="5" class="text-center">Giỏ hàng của bạn đang trống.</td></tr>';
            checkoutButton.disabled = true;
        } else {
            cart.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="cart-thumbnail me-3" style="background-image: url('${item.image}');"></div>
                            <div>
                                <h6 class="cart-product-title">${item.name}</h6>
                                <small class="text-muted">${item.description.substring(0, 50)}...</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end cart-product-price">${item.price.toLocaleString()}đ</td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <input type="text" class="form-control cart-quantity-input" value="${item.quantity}" readonly>
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td class="text-end cart-product-price">${(item.price * item.quantity).toLocaleString()}đ</td>
                    <td class="text-center">
                        <button class="cart-remove-btn" onclick="removeItem(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                cartItemsContainer.appendChild(row);
                totalPrice += item.price * item.quantity;
            });
            checkoutButton.disabled = false;
        }
        
        totalPriceElement.textContent = totalPrice.toLocaleString() + 'đ';
        updateCartCount();
    }
    
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    window.updateQuantity = function(index, change) {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        if (index >= 0 && index < cart.length) {
            cart[index].quantity += change;
            
            if (cart[index].quantity <= 0) {
                removeItem(index);
            } else {
                updateCart();
            }
        }
    };
    
    // Xóa sản phẩm khỏi giỏ hàng
    window.removeItem = function(index) {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        if (index >= 0 && index < cart.length) {
            cart.splice(index, 1);
            updateCart();
        }
    };
    
    // Xử lý nút xóa giỏ hàng
    document.getElementById('clear-cart').addEventListener('click', function() {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        if (cart.length > 0) {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
                cart = [];
                updateCart();
            }
        }
    });
    
    // Xử lý nút thanh toán
    document.getElementById('checkout').addEventListener('click', function() {
        if (!isLoggedIn) {
            showLoginModal();
            return;
        }
        
        if (cart.length > 0) {
            alert('Cảm ơn bạn đã mua hàng! Đơn hàng của bạn đang được xử lý.');
            cart = [];
            updateCart();
            
            // Đóng modal giỏ hàng
            const cartModal = bootstrap.Modal.getInstance(document.getElementById('cart-modal'));
            cartModal.hide();
        }
    });
    
    // Hiển thị modal đăng nhập
    function showLoginModal() {
        const loginModal = new bootstrap.Modal(document.getElementById('login-modal'));
        loginModal.show();
    }
    
    // Xử lý comparison slider
    if (document.querySelector('.comparison-slider')) {
        const comparisonSlider = document.querySelector('.comparison-slider');
        const comparisonHandle = comparisonSlider.querySelector('.comparison-handle');
        const comparisonBefore = comparisonSlider.querySelector('.comparison-before');
        
        function setComparisonPosition(x) {
            const sliderWidth = comparisonSlider.offsetWidth;
            let position = (x / sliderWidth) * 100;
            position = Math.max(0, Math.min(100, position));
            
            comparisonHandle.style.left = `${position}%`;
            comparisonBefore.style.clipPath = `polygon(0 0, ${position}% 0, ${position}% 100%, 0 100%)`;
        }
        
        // Set giá trị ban đầu
        setComparisonPosition(comparisonSlider.offsetWidth / 2);
        
        // Mouse events
        let isDragging = false;
        
        comparisonHandle.addEventListener('mousedown', () => {
            isDragging = true;
        });
        
        window.addEventListener('mouseup', () => {
            isDragging = false;
        });
        
        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            const sliderRect = comparisonSlider.getBoundingClientRect();
            const x = e.clientX - sliderRect.left;
            
            setComparisonPosition(x);
        });
        
        // Touch events
        comparisonHandle.addEventListener('touchstart', () => {
            isDragging = true;
        });
        
        window.addEventListener('touchend', () => {
            isDragging = false;
        });
        
        window.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const sliderRect = comparisonSlider.getBoundingClientRect();
            const x = e.touches[0].clientX - sliderRect.left;
            
            setComparisonPosition(x);
        });
        
        // Direct click on slider
        comparisonSlider.addEventListener('click', (e) => {
            const sliderRect = comparisonSlider.getBoundingClientRect();
            const x = e.clientX - sliderRect.left;
            
            setComparisonPosition(x);
        });
    }
    
    // Product filtering
    const filterButtons = document.querySelectorAll('.product-filter-btn');
    const productItems = document.querySelectorAll('.product-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Filter products
            productItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    // Add fade-in animation
                    item.classList.add('fade-in');
                    setTimeout(() => {
                        item.classList.remove('fade-in');
                    }, 500);
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Product wishlist functionality
    document.querySelectorAll('.product-wishlist-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }
            
            this.classList.toggle('active');
            
            // Không cần thay đổi innerHTML nữa vì đã có sẵn cả hai icon trong HTML
            const heartFill = this.querySelector('.bi-heart-fill');
            
            // Thêm hiệu ứng nhịp đập khi được kích hoạt
            if (this.classList.contains('active')) {
                heartFill.style.animation = 'none';
                setTimeout(() => {
                    heartFill.style.animation = '';
                }, 10);
            }
        });
    });
    
    // Xử lý các nút quick-action
    const wishlistBtn = document.getElementById('wishlistBtn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }
        });
    }
    
    const recentViewBtn = document.getElementById('recentViewBtn');
    if (recentViewBtn) {
        recentViewBtn.addEventListener('click', function() {
            // Không làm gì
        });
    }
    
    // Add to cart functionality
    document.querySelectorAll('.product-add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!isLoggedIn) {
                showLoginModal();
                return;
            }
            
            const productId = parseInt(this.getAttribute('data-product'));
            const product = products.find(p => p.id === productId);
            
            if (product) {
                // Thêm hiệu ứng khi thêm vào giỏ hàng
                this.innerHTML = '<i class="bi bi-check"></i> Đã thêm';
                this.classList.add('btn-success');
                
                // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
                const existingItemIndex = cart.findIndex(item => item.id === productId);
                
                if (existingItemIndex !== -1) {
                    // Tăng số lượng nếu đã có
                    cart[existingItemIndex].quantity += 1;
                } else {
                    // Thêm mới nếu chưa có
                    cart.push({
                        id: product.id,
                        name: product.name,
                        description: product.description,
                        price: product.price,
                        quantity: 1,
                        image: product.image
                    });
                }
                
                updateCart();
                
                // Sau 2 giây, khôi phục lại nút
                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-cart-plus"></i> Thêm vào giỏ';
                    this.classList.remove('btn-success');
                }, 1500);
            }
        });
    });
    
    // Quick View Functionality
    document.querySelectorAll('.product-quick-view-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-product'));
            const product = products.find(p => p.id === productId);
            
            if (product) {
                // Cập nhật thông tin sản phẩm trong modal
                document.getElementById('quickViewTitle').textContent = product.name;
                document.getElementById('quickViewPrice').textContent = product.price.toLocaleString() + 'đ';
                document.getElementById('quickViewDescription').textContent = product.description;
                document.getElementById('quickViewImage').style.backgroundImage = `url('${product.image}')`;
                
                // Reset số lượng về 1
                document.getElementById('quantityInput').value = 1;
                
                // Cập nhật các nút trong modal
                document.getElementById('quickViewAddToCart').setAttribute('data-product', productId);
                document.getElementById('quickViewWishlist').setAttribute('data-product', productId);
            }
        });
    });
    
    // Xử lý tăng giảm số lượng trong Quick View
    document.getElementById('decreaseQuantity').addEventListener('click', function() {
        const input = document.getElementById('quantityInput');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    });
    
    document.getElementById('increaseQuantity').addEventListener('click', function() {
        const input = document.getElementById('quantityInput');
        let value = parseInt(input.value);
        input.value = value + 1;
    });
    
    // Quick View Add to Cart Button
    document.getElementById('quickViewAddToCart').addEventListener('click', function() {
        if (!isLoggedIn) {
            const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
            quickViewModal.hide();
            showLoginModal();
            return;
        }
        
        const productId = parseInt(this.getAttribute('data-product'));
        const product = products.find(p => p.id === productId);
        
        if (product) {
            const quantity = parseInt(document.getElementById('quantityInput').value);
            
            // Thêm hiệu ứng khi thêm vào giỏ hàng
            this.innerHTML = '<i class="bi bi-check"></i> Đã thêm';
            this.classList.add('btn-success');
            
            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            const existingItemIndex = cart.findIndex(item => item.id === productId);
            
            if (existingItemIndex !== -1) {
                // Tăng số lượng nếu đã có
                cart[existingItemIndex].quantity += quantity;
            } else {
                // Thêm mới nếu chưa có
                cart.push({
                    id: product.id,
                    name: product.name,
                    description: product.description,
                    price: product.price,
                    quantity: quantity,
                    image: product.image
                });
            }
            
            updateCart();
            
            // Sau 1.5 giây, khôi phục lại nút và đóng modal
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ hàng';
                this.classList.remove('btn-success');
                
                const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                quickViewModal.hide();
            }, 1500);
        }
    });
    
    // Quick View Wishlist Button
    document.getElementById('quickViewWishlist').addEventListener('click', function() {
        if (!isLoggedIn) {
            const quickViewModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
            quickViewModal.hide();
            showLoginModal();
            return;
        }
        
        // Toggle active state
        this.classList.toggle('active');
        
        if (this.classList.contains('active')) {
            this.innerHTML = '<i class="bi bi-heart-fill me-1"></i>Đã thêm vào yêu thích';
        } else {
            this.innerHTML = '<i class="bi bi-heart me-1"></i>Thêm vào yêu thích';
        }
    });
    
    // Xử lý quick-view-thumb
    document.querySelectorAll('.quick-view-thumb').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const bgImage = this.style.backgroundImage;
            document.getElementById('quickViewImage').style.backgroundImage = bgImage;
            
            // Cập nhật trạng thái active
            document.querySelectorAll('.quick-view-thumb').forEach(t => {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Xử lý color-option
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
    
    // Login Form Submit Handler
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Simulate successful login
        isLoggedIn = true;
        
        // Close login modal
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('login-modal'));
        loginModal.hide();
        
        // Change login button to user profile
        const loginButton = document.getElementById('loginButton');
        const username = document.getElementById('login-email').value.split('@')[0];
        const avatar = username.charAt(0).toUpperCase();
        
        loginButton.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="d-none d-md-inline me-2">Xin chào!</span>
                <span class="badge bg-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">${avatar}</span>
            </div>
        `;
        
        loginButton.href = "#user-profile";
        loginButton.removeAttribute('data-bs-toggle');
    });
    
    // Register Form Submit Handler
    document.getElementById('register-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Validate password match
        const password = document.getElementById('register-password').value;
        const confirmPassword = document.getElementById('register-confirm-password').value;
        
        if (password !== confirmPassword) {
            alert('Mật khẩu xác nhận không khớp!');
            return;
        }
        
        // Simulate successful registration
        isLoggedIn = true;
        
        // Close register modal
        const registerModal = bootstrap.Modal.getInstance(document.getElementById('register-modal'));
        registerModal.hide();
        
        // Change login button to user profile
        const loginButton = document.getElementById('loginButton');
        const username = document.getElementById('register-name').value;
        const avatar = username.charAt(0).toUpperCase();
        
        loginButton.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="d-none d-md-inline me-2">Xin chào!</span>
                <span class="badge bg-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">${avatar}</span>
            </div>
        `;
        
        loginButton.href = "#user-profile";
        loginButton.removeAttribute('data-bs-toggle');
    });
    
    // Newsletter Form Submit Handler
    document.querySelector('.newsletter-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const emailInput = document.querySelector('.newsletter-input');
        const email = emailInput.value.trim();
        
        if (email === '') {
            alert('Vui lòng nhập địa chỉ email!');
            return;
        }
        
        // Simulated successful subscription
        emailInput.value = '';
        alert('Cảm ơn bạn đã đăng ký! Bạn sẽ nhận được các thông tin mới nhất từ CameraVN.');
    });
    
    // Hiệu ứng Navbar khi scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('shadow');
        } else {
            navbar.classList.remove('shadow');
        }
    });
    
    // Smooth Scroll cho các links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#' && 
                this.getAttribute('href') !== '#!' && 
                !this.getAttribute('href').includes('modal') &&
                document.querySelector(this.getAttribute('href'))) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80, // Trừ chiều cao của navbar
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // Konami Code Easter Egg
    let konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
    let konamiIndex = 0;
    
    document.addEventListener('keydown', function(e) {
        if (e.key === konamiCode[konamiIndex]) {
            konamiIndex++;
            
            if (konamiIndex === konamiCode.length) {
                // Kích hoạt easter egg
                document.body.style.transition = 'all 1s ease';
                
                // Party mode!
                let partyInterval = setInterval(() => {
                    const r = Math.floor(Math.random() * 256);
                    const g = Math.floor(Math.random() * 256);
                    const b = Math.floor(Math.random() * 256);
                    document.body.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
                }, 300);
                
                // Tắt party mode sau 5 giây
                setTimeout(() => {
                    clearInterval(partyInterval);
                    document.body.style.backgroundColor = '';
                    konamiIndex = 0;
                }, 5000);
            }
        } else {
            konamiIndex = 0;
        }
    });
    
    // Fix dropdown menu behavior on mobile
    function handleMobileNavigation() {
        if (window.innerWidth < 992) {
            document.querySelectorAll('.dropdown-toggle').forEach(dropdownToggle => {
                dropdownToggle.addEventListener('click', function(e) {
                    const parent = this.parentElement;
                    const dropdown = parent.querySelector('.dropdown-menu');
                    
                    // Nếu đã được xử lý bởi Bootstrap
                    if (e.target.getAttribute('aria-expanded') === 'true') {
                        return;
                    }
                    
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle dropdown
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        // Đóng tất cả dropdown khác
                        document.querySelectorAll('.dropdown-menu.show').forEach(openDropdown => {
                            openDropdown.classList.remove('show');
                            openDropdown.previousElementSibling.setAttribute('aria-expanded', 'false');
                        });
                        
                        dropdown.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        }
    }
    
    // Chạy khi tải trang và khi thay đổi kích thước
    handleMobileNavigation();
    window.addEventListener('resize', handleMobileNavigation);
    
    // Khởi tạo giỏ hàng
    updateCart();
});