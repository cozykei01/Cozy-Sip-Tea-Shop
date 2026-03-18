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
    <style>
        /* --- Payment Modal Styles --- */
        .payment-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
        }

        .payment-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .payment-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -40%);
            width: 95%;
            max-width: 450px;
            background: white;
            border-radius: 1.5rem;
            z-index: 2001;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 1.5rem;
            box-shadow: 0 1.5rem 3rem rgba(0, 66, 37, 0.15);
        }

        .payment-modal.active {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%);
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .payment-header h3 {
            color: #004225;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .close-payment {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.25rem;
            border: 2px solid #f5f5f5;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: #e0e0e0;
            background: #fafafa;
        }

        .payment-option.selected {
            border-color: #004225;
            background: rgba(0, 66, 37, 0.03);
        }

        .payment-icon {
            width: 3rem;
            height: 3rem;
            background: #f0f4f2;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #004225;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .payment-option.selected .payment-icon {
            background: #004225;
            color: #fff;
        }

        .payment-info {
            flex: 1;
        }

        .payment-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2D3E33;
            margin: 0 0 0.2rem 0;
        }

        .payment-info p {
            font-size: 0.85rem;
            color: #888;
            margin: 0;
        }

        .confirm-payment-btn {
            width: 100%;
            padding: 1rem;
            background-color: #004225;
            color: #fff;
            border: none;
            border-radius: 3.125rem;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .confirm-payment-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>
    <script>
        const userIsLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    </script>
</head>
<body>
    <?php 
    $activePage = 'home';
    include 'partials/navbar.php'; 
    ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-subtitle">Premium Tea Collection</span>
            <h1>Sip the Serenity,<br>Taste the Tradition</h1>
            <p>Elevate your everyday with our hand-picked, premium tea collection. Experience the perfect blend of taste and tranquility in every cup.</p>
        </div>
    </section>

    <!-- Event Products Section -->
    <section class="event-products-section" style="margin-top: 4rem; padding: 4rem 5%; background-color: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div class="section-header" style="text-align: left; margin-bottom: 2.5rem;">
                <h2 style="font-size: 2.2rem; color: var(--cozy-primary);">Event Products</h2>
                <p style="color: var(--cozy-text); opacity: 0.8; font-size: 1.1rem; margin-top: 0.5rem;">Grab our limited-time seasonal brews and deals!</p>
            </div>
            <div class="products-grid">
            <?php if(isset($eventProducts) && !empty($eventProducts)): ?>
                <?php foreach($eventProducts as $product): ?>
                <?php 
                    // Dynamic image assignment
                    $img = 'https://loremflickr.com/500/500/coffee,drink/all';
                    $cat = strtolower($product['product_category_name'] ?? '');
                    if (strpos($cat, 'bakery') !== false) {
                        $img = 'https://loremflickr.com/500/500/bakery/all';
                    } elseif (strpos($cat, 'tea') !== false) {
                        $img = 'https://loremflickr.com/500/500/tea,drink/all';
                    }
                    $name = strtolower($product['product_name']);
                    if (strpos($name, 'americano') !== false) $img = 'https://images.unsplash.com/photo-1551030173-122aabc4489c?auto=format&fit=crop&q=80&w=500';
                    if (strpos($name, 'latte') !== false) $img = 'https://images.unsplash.com/photo-1570968915860-54d5c301fa9f?auto=format&fit=crop&q=80&w=500';
                    if (strpos($name, 'mocha') !== false) $img = 'https://loremflickr.com/500/500/mocha,coffee/all';
                    if (strpos($name, 'chocolate') !== false) $img = 'https://loremflickr.com/500/500/hotchocolate,drink/all';
                    if (strpos($name, 'croissant') !== false) $img = 'https://loremflickr.com/500/500/croissant,bakery/all';
                    if (strpos($name, 'cookie') !== false) $img = 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=500';
                    
                    $finalPrice = !empty($product['event_price']) ? $product['event_price'] : $product['price'];
                ?>
                <div class="product-card" data-id="<?php echo htmlspecialchars($product['product_id']); ?>" data-name="<?php echo htmlspecialchars($product['product_name']); ?>" data-price="<?php echo htmlspecialchars($finalPrice); ?>" data-img="<?php echo $img; ?>" data-points="<?php echo htmlspecialchars($product['earned_point_value']); ?>">
                    <div class="product-img-wrapper">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-img">
                        <span class="badge">Event</span>
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo htmlspecialchars($product['product_category_name'] ?? 'Special'); ?></div>
                        <h3 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p class="product-desc" style="display: flex; gap: 0.5rem; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
                            <?php if(!empty($product['event_price'])): ?>
                                <span style="text-decoration: line-through; color: #999; font-size: 0.85rem;"><?php echo number_format($product['price'], 0); ?> Ks</span>
                            <?php endif; ?>
                            <span style="color: var(--cozy-green); font-size: 0.85rem;">+<?php echo htmlspecialchars($product['earned_point_value']); ?> Pts</span>
                        </p>
                        <div class="product-footer">
                            <span class="product-price"><?php echo number_format($finalPrice, 0); ?> Ks</span>
                            <button class="add-to-cart" aria-label="Add to cart"><i class="fa-solid fa-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No event products available right now.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


    <!-- Floating Cart Icon -->
    <div class="floating-cart" id="floatingCart" style="display: none;">
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
            <div class="cart-total" style="display: flex; flex-direction: column; align-items: stretch; gap: 0.5rem; width: 100%;">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <span>Total:</span>
                    <span id="cartTotalPrice" style="font-weight: 700;">0 Ks</span>
                </div>
                <div id="pointsRow" style="display: flex; justify-content: space-between; align-items: center; width: 100%; color: var(--cozy-green); font-size: 0.95rem;">
                    <span>Total Earned Points:</span>
                    <span id="cartTotalPoints" style="font-weight: 600;">+0 Pts</span>
                </div>
            </div>
            <button class="checkout-btn" id="proceedToCheckoutBtn" style="width: 100%; margin-top: 1rem;">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="payment-modal-overlay" id="paymentModalOverlay"></div>
    <div class="payment-modal" id="paymentModal">
        <div class="payment-header">
            <h3>Select Payment Method</h3>
            <button class="close-payment" id="closePaymentModal"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="payment-body">
            <div class="payment-options">
                <div class="payment-option" data-method="kpay">
                    <div class="payment-icon"><i class="fa-solid fa-mobile-alt"></i></div>
                    <div class="payment-info">
                        <h4>KPay</h4>
                        <p>KBZ Pay Digital Wallet</p>
                    </div>
                </div>
                <div class="payment-option" data-method="wave">
                    <div class="payment-icon"><i class="fa-solid fa-wallet"></i></div>
                    <div class="payment-info">
                        <h4>Wave Money</h4>
                        <p>Wave Digital Wallet</p>
                    </div>
                </div>
                <div class="payment-option" data-method="cod">
                    <div class="payment-icon"><i class="fa-solid fa-truck"></i></div>
                    <div class="payment-info">
                        <h4>Cash on Delivery</h4>
                        <p>Pay when you receive</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="payment-footer">
            <button class="confirm-payment-btn" id="confirmPaymentBtn" disabled>Confirm Order</button>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="assets/js/home.view.js"></script>
</body>
</html>
