<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Sip Tea Shop - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home.view.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php?page=home" class="logo">
                <i class="fa-solid fa-mug-hot"></i> Cozy Sip
            </a>
            
            <ul class="nav-links">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>

            <div class="user-actions">
                <div class="point-balance">
                    <i class="fa-solid fa-star"></i> <span>150 Pts</span>
                </div>
                <button class="noti-btn" aria-label="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span class="noti-badge">3</span>
                </button>
                <div class="profile-container" style="position: relative;">
                    <button class="profile-btn" id="profileDropdownBtn" style="background:none; border:none; padding:0; cursor:pointer;">
                        <div class="profile-img">
                            <img src="https://ui-avatars.com/api/?name=User&background=004225&color=fff&rounded=true&bold=true" alt="Profile">
                        </div>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-header">
                            <span class="user-name">User</span>
                            <span class="user-email">user@cozysip.com</span>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa-regular fa-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="fa-solid fa-box"></i> My Orders</a></li>
                            <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
                            <li class="logout-item"><a href="/index.php?page=login"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-subtitle">Premium Tea Collection</span>
            <h1>Sip the Serenity,<br>Taste the Tradition</h1>
            <p>Elevate your everyday with our hand-picked, premium tea collection. Experience the perfect blend of taste and tranquility in every cup.</p>
        </div>
    </section>


    <!-- Floating Cart Icon -->
    <div class="floating-cart" id="floatingCart">
        <div class="cart-icon-wrapper">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-count" id="cartCount">0</span>
        </div>
        <span class="cart-label">Order</span>
    </div>

    <!-- Cart Modal -->
    <div class="cart-modal-overlay" id="cartModalOverlay"></div>
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-header">
            <h3>Your Order</h3>
            <button class="close-modal" id="closeCartModal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-modal-body" id="cartItemsContainer">
            <!-- Cart Items will be injected here by JS -->
            <div class="empty-cart-message">
                <i class="fa-solid fa-basket-shopping"></i>
                <p>Your cart is empty.</p>
            </div>
        </div>
        <div class="cart-modal-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotalPrice">$0.00</span>
            </div>
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <a href="#" class="logo footer-logo">
                    <i class="fa-solid fa-mug-hot"></i> Cozy Sip
                </a>
                <p>Curating the finest teas from around the world to bring comfort and joy to your daily cup.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Shop Menu</a></li>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Customer Care</h3>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-newsletter">
                <h3>Stay Connected</h3>
                <p>Subscribe to our newsletter for exclusive offers and tea updates.</p>
                <form action="#" class="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit" aria-label="Subscribe"><i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Cozy Sip Tea Shop. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/home.view.js"></script>
</body>
</html>
