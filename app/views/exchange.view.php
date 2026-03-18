<?php
$userIsLoggedIn = isset($_SESSION['user_id']);
$userPoints = $userIsLoggedIn ? $_SESSION['user_points'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Sip Tea Shop - Exchange</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home.view.css">
    <style>
        .exchange-hero {
            padding: 8rem 2rem 4rem;
            background: linear-gradient(rgba(11, 38, 17, 0.8), rgba(11, 38, 17, 0.8)), url('https://images.unsplash.com/photo-1544787210-2211d44b565a?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
        }
        .exchange-hero h1 { font-size: 3rem; margin-bottom: 1rem; }
        .exchange-content {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            min-height: 40vh;
        }
        
        .exchange-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .exchange-card {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
        }

        .exchange-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .card-img-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .exchange-card:hover .card-img-wrapper img {
            transform: scale(1.1);
        }

        .points-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #e6b325;
            color: #0b2611;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 10px rgba(230, 179, 37, 0.3);
        }

        .card-body {
            padding: 1.5rem;
            text-align: left;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body h3 {
            font-size: 1.25rem;
            color: #0b2611;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .card-body p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .redeem-btn {
            width: 100%;
            padding: 0.8rem;
            background: #0b2611;
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .redeem-btn:hover {
            background: #1a4d29;
        }

        .redeem-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .stock-info {
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 1rem;
            display: block;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php 
    $activePage = 'exchange';
    include 'partials/navbar.php'; 
    ?>

    <header class="exchange-hero">
        <h1>Point Exchange</h1>
        <p>Use your earned points to enjoy free treats!</p>
    </header>

    <main class="exchange-content">
        <div class="exchange-grid">
            <?php if (!empty($exchangeProducts)): ?>
                <?php foreach ($exchangeProducts as $product): ?>
                    <?php 
                        $img = 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&q=80&w=500'; // Default coffee
                        $name = strtolower($product['product_name']);
                        if (strpos($name, 'espresso') !== false) $img = 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?auto=format&fit=crop&q=80&w=500';
                        if (strpos($name, 'americano') !== false) $img = 'https://images.unsplash.com/photo-1551030173-122aabc4489c?auto=format&fit=crop&q=80&w=500';
                        if (strpos($name, 'latte') !== false) $img = 'https://images.unsplash.com/photo-1570968915860-54d5c301fa9f?auto=format&fit=crop&q=80&w=500';
                        if (strpos($name, 'green tea') !== false) $img = 'https://images.unsplash.com/photo-1515696431267-434d28362402?auto=format&fit=crop&q=80&w=500';
                        if (strpos($name, 'croissant') !== false) $img = 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=500';
                        if (strpos($name, 'cookie') !== false) $img = 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&q=80&w=500';
                    ?>
                    <div class="exchange-card">
                        <div class="card-img-wrapper">
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <div class="points-badge">
                                <i class="fa-solid fa-star"></i> <?php echo number_format($product['points_required']); ?> Pts
                            </div>
                        </div>
                        <div class="card-body">
                            <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            <span class="stock-info">Available: <?php echo $product['stock_quantity']; ?> items left</span>
                            
                            <button class="redeem-btn" 
                                    onclick="exchangeItem(<?php echo $product['exchange_product_id']; ?>, '<?php echo addslashes($product['product_name']); ?>', <?php echo $product['points_required']; ?>, '<?php echo $img; ?>')"
                                    <?php echo ($userPoints < $product['points_required'] || $product['stock_quantity'] <= 0) ? 'disabled' : ''; ?>>
                                <i class="fa-solid fa-gift"></i> Exchange Now
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="placeholder-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-gift" style="font-size: 4rem; color: #e6b325; margin-bottom: 2rem;"></i>
                    <h2>New Rewards Coming Soon!</h2>
                    <p>We're currently updating our catalog with more delicious treats. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Floating Exchange Button -->
    <div class="floating-cart" id="exchangeCartBtn" style="display: none;">
        <div class="cart-icon-wrapper">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-count" id="exchangeCount">0</span>
        </div>
        <span class="cart-label">Exchange</span>
    </div>

    <!-- Exchange Modal -->
    <div class="cart-modal-overlay" id="exchangeModalOverlay"></div>
    <div class="cart-modal" id="exchangeModal">
        <div class="cart-modal-header">
            <h3>Your Exchange</h3>
            <button class="close-modal" id="closeExchangeModal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-modal-body" id="exchangeItemsContainer">
            <!-- Items injected here -->
        </div>
        <div class="cart-modal-footer" style="padding: 1.5rem; border-top: 1px solid #eee;">
            <div class="cart-total" style="display: flex; justify-content: space-between; width: 100%;">
                <span style="font-weight: 600;">Total Points:</span>
                <span id="exchangeTotalPoints" style="font-weight: 700; color: #e6b325; font-size: 1.2rem;">0 Pts</span>
            </div>
            <button class="checkout-btn" id="confirmExchangeBtn" style="width: 100%; margin-top: 1rem; background: #004225; color: white; border: none; padding: 1rem; border-radius: 2rem; font-weight: 700; cursor: pointer;">Confirm Exchange</button>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script>
        const userIsLoggedIn = <?php echo json_encode($userIsLoggedIn); ?>;
        const currentPoints = <?php echo $userPoints; ?>;
        let exchangeCart = [];

        // Elements
        const exchangeCartBtn = document.getElementById('exchangeCartBtn');
        const exchangeCount = document.getElementById('exchangeCount');
        const exchangeModal = document.getElementById('exchangeModal');
        const exchangeModalOverlay = document.getElementById('exchangeModalOverlay');
        const exchangeItemsContainer = document.getElementById('exchangeItemsContainer');
        const exchangeTotalPoints = document.getElementById('exchangeTotalPoints');
        const confirmExchangeBtn = document.getElementById('confirmExchangeBtn');

        function exchangeItem(exchangeProductId, productName, pointsRequired, productImg) {
            if (!userIsLoggedIn) {
                if (confirm("You need to be logged in to exchange items. Login now?")) {
                    window.location.href = "index.php?page=login";
                }
                return;
            }

            // Check if already in cart
            const existing = exchangeCart.find(item => item.id === exchangeProductId);
            if (existing) {
                existing.quantity += 1;
            } else {
                exchangeCart.push({
                    id: exchangeProductId,
                    name: productName,
                    points: pointsRequired,
                    img: productImg,
                    quantity: 1
                });
            }

            updateExchangeUI();
            
            // Show alert/feedback
            const toast = document.createElement('div');
            toast.style = "position: fixed; bottom: 100px; right: 20px; background: #004225; color: white; padding: 1rem 2rem; border-radius: 2rem; z-index: 10000; animation: fadeInUp 0.5s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2);";
            toast.innerHTML = `<i class="fa-solid fa-check-circle"></i> Added ${productName} to exchange list`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function updateExchangeUI() {
            const totalCount = exchangeCart.reduce((sum, item) => sum + item.quantity, 0);
            const totalPoints = exchangeCart.reduce((sum, item) => sum + (item.points * item.quantity), 0);

            exchangeCount.textContent = totalCount;
            exchangeCartBtn.style.display = totalCount > 0 ? 'flex' : 'none';
            exchangeTotalPoints.textContent = totalPoints.toLocaleString() + ' Pts';

            // Check if user has enough points
            if (totalPoints > currentPoints) {
                exchangeTotalPoints.style.color = '#dc2626';
                confirmExchangeBtn.disabled = true;
                confirmExchangeBtn.style.opacity = '0.5';
                confirmExchangeBtn.textContent = 'Insufficient Points';
            } else {
                exchangeTotalPoints.style.color = '#e6b325';
                confirmExchangeBtn.disabled = false;
                confirmExchangeBtn.style.opacity = '1';
                confirmExchangeBtn.textContent = 'Confirm Exchange';
            }

            renderExchangeItems();
        }

        function renderExchangeItems() {
            if (exchangeCart.length === 0) {
                exchangeItemsContainer.innerHTML = `
                    <div class="empty-cart-message">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <p>Your exchange list is empty.</p>
                    </div>`;
                return;
            }

            exchangeItemsContainer.innerHTML = exchangeCart.map(item => `
                <div class="cart-item">
                    <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                    <div class="cart-item-details">
                        <div class="cart-item-title">${item.name}</div>
                        <div class="cart-item-price">${item.points.toLocaleString()} Pts</div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="qty-btn" onclick="changeQty(${item.id}, -1)"><i class="fa-solid fa-minus"></i></button>
                        <span>${item.quantity}</span>
                        <button class="qty-btn" onclick="changeQty(${item.id}, 1)"><i class="fa-solid fa-plus"></i></button>
                        <button class="remove-item" onclick="removeExchangeItem(${item.id})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `).join('');
        }

        function removeExchangeItem(id) {
            exchangeCart = exchangeCart.filter(item => item.id !== id);
            updateExchangeUI();
        }

        function changeQty(id, delta) {
            const item = exchangeCart.find(i => i.id === id);
            if (item) {
                item.quantity += delta;
                if (item.quantity <= 0) {
                    exchangeCart = exchangeCart.filter(i => i.id !== id);
                }
                updateExchangeUI();
            }
        }

        // Toggle Modal
        exchangeCartBtn.onclick = () => {
            exchangeModal.classList.add('active');
            exchangeModalOverlay.classList.add('active');
        };

        const closeExchangeModal = () => {
            exchangeModal.classList.remove('active');
            exchangeModalOverlay.classList.remove('active');
        };

        document.getElementById('closeExchangeModal').onclick = closeExchangeModal;
        exchangeModalOverlay.onclick = closeExchangeModal;

        confirmExchangeBtn.onclick = () => {
            if (exchangeCart.length === 0) return;
            
            if (confirm('Are you sure you want to proceed with this exchange?')) {
                confirmExchangeBtn.disabled = true;
                confirmExchangeBtn.textContent = 'Processing...';

                fetch('index.php?page=exchange_process', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ exchangeCart: exchangeCart })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        exchangeCart = [];
                        updateExchangeUI();
                        closeExchangeModal();
                        
                        // Update points in navbar if exists
                        const pointDisplay = document.querySelector('.points-balance span');
                        if (pointDisplay) {
                            pointDisplay.textContent = data.newPoints.toLocaleString() + ' Pts';
                        }
                        
                        // Reload to update stock and points consistently
                        location.reload();
                    } else {
                        alert(data.message);
                        confirmExchangeBtn.disabled = false;
                        confirmExchangeBtn.textContent = 'Confirm Exchange';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    confirmExchangeBtn.disabled = false;
                    confirmExchangeBtn.textContent = 'Confirm Exchange';
                });
            }
        };
    </script>
    <script src="assets/js/home.view.js"></script>
</body>
</html>
