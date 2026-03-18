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
                <div class="profile-img">
                    <img src="https://ui-avatars.com/api/?name=User&background=004225&color=fff&rounded=true&bold=true" alt="Profile">
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
            <div class="hero-buttons">
                <button class="btn btn-primary">Explore Menu <i class="fa-solid fa-arrow-right"></i></button>
                <button class="btn btn-outline">Our Story</button>
            </div>
        </div>
    </section>

    <!-- Product Card Section -->
    <section class="products-section">
        <div class="section-header">
            <h2>Our Signature Teas</h2>
            <p>Discover our most beloved blends crafted for pure relaxation</p>
        </div>
        <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1597481499750-3e6b22637e12?auto=format&fit=crop&q=80&w=500" alt="Matcha Green Tea" class="product-img">
                    <span class="badge">Bestseller</span>
                    <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <div class="product-category">Green Tea</div>
                    <h3 class="product-title">Premium Matcha</h3>
                    <p class="product-desc">Ceremonial grade matcha from Uji, Japan with a smooth, umami-rich flavor profile.</p>
                    <div class="product-footer">
                        <span class="product-price">$18.00</span>
                        <button class="add-to-cart" aria-label="Add to cart"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1576092768241-dec231879fc3?auto=format&fit=crop&q=80&w=500" alt="Earl Grey Tea" class="product-img">
                    <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <div class="product-category">Black Tea</div>
                    <h3 class="product-title">Royal Earl Grey</h3>
                    <p class="product-desc">Classic black tea infused with cold-pressed bergamot oil for a refreshing citrus lift.</p>
                    <div class="product-footer">
                        <span class="product-price">$14.50</span>
                        <button class="add-to-cart" aria-label="Add to cart"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1627449272828-86bc25bf9293?auto=format&fit=crop&q=80&w=500" alt="Chamomile Tea" class="product-img">
                    <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <div class="product-category">Herbal Tea</div>
                    <h3 class="product-title">Calming Chamomile</h3>
                    <p class="product-desc">Pure organic Egyptian chamomile flowers for a peaceful evening wind-down.</p>
                    <div class="product-footer">
                        <span class="product-price">$12.00</span>
                        <button class="add-to-cart" aria-label="Add to cart"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1594631252845-29fc4cdc8e01?auto=format&fit=crop&q=80&w=500" alt="Oolong Tea" class="product-img">
                    <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                </div>
                <div class="product-info">
                    <div class="product-category">Oolong Tea</div>
                    <h3 class="product-title">Mountain Oolong</h3>
                    <p class="product-desc">Lightly roasted oolong with floral notes and a sweet, lingering finish.</p>
                    <div class="product-footer">
                        <span class="product-price">$16.50</span>
                        <button class="add-to-cart" aria-label="Add to cart"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
</body>
</html>
