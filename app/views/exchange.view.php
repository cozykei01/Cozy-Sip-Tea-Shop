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
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
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

        /* --- Receipt Modal Styles --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 10002;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 1.5rem;
            z-index: 10003;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: scale(0.95);
            box-shadow: 0 1.5rem 3rem rgba(0, 66, 37, 0.15);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
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
                        if (strpos($name, 'green tea') !== false) $img = 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?auto=format&fit=crop&q=80&w=500';
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
                            <span class="stock-info" id="stock-qty-<?php echo $product['exchange_product_id']; ?>">Available: <?php echo $product['stock_quantity']; ?> items left</span>
                            
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
        let currentPoints = <?php echo $userPoints; ?>;
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
            
            // Check for stock insufficiency
            let anyOverStock = false;
            exchangeCart.forEach(item => {
                const stockEl = document.getElementById(`stock-${item.id}`);
                if (stockEl) {
                    const available = parseInt(stockEl.textContent);
                    if (!isNaN(available) && item.quantity > available) {
                        anyOverStock = true;
                    }
                }
            });

            exchangeCount.textContent = totalCount;
            exchangeCartBtn.style.display = totalCount > 0 ? 'flex' : 'none';
            exchangeTotalPoints.textContent = totalPoints.toLocaleString() + ' Pts';

            // Check if user has enough points or enough stock
            if (totalPoints > currentPoints) {
                exchangeTotalPoints.style.color = '#dc2626';
                confirmExchangeBtn.disabled = true;
                confirmExchangeBtn.style.opacity = '0.5';
                confirmExchangeBtn.textContent = 'Insufficient Points';
            } else if (anyOverStock) {
                exchangeTotalPoints.style.color = '#e6b325';
                confirmExchangeBtn.disabled = true;
                confirmExchangeBtn.style.opacity = '0.5';
                confirmExchangeBtn.textContent = 'Insufficient Stock';
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

            exchangeItemsContainer.innerHTML = exchangeCart.map(item => {
                const stockEl = document.getElementById(`stock-${item.id}`);
                const available = stockEl ? parseInt(stockEl.textContent) : 999;
                const isOverStock = item.quantity > available;

                return `
                <div class="cart-item" style="flex-wrap: wrap;">
                    <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                    <div class="cart-item-details">
                        <div class="cart-item-title">${item.name}</div>
                        <div class="cart-item-price">${item.points.toLocaleString()} Pts</div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="qty-btn" onclick="changeQty(${item.id}, -1)"><i class="fa-solid fa-minus"></i></button>
                        <span style="${isOverStock ? 'color: #dc2626; font-weight: 700;' : ''}">${item.quantity}</span>
                        <button class="qty-btn" onclick="changeQty(${item.id}, 1)" ${isOverStock ? 'style="opacity: 0.5;"' : ''}><i class="fa-solid fa-plus"></i></button>
                        <button class="remove-item" onclick="removeExchangeItem(${item.id})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                `;
            }).join('');
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
                // Keep current items to update stock later
                const itemsToUpdate = [...exchangeCart];
                
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
                        // 1. Success message
                        const toast = document.createElement('div');
                        toast.style = "position: fixed; top: 100px; left: 0; right: 0; width: fit-content; margin: 0 auto; background: #004225; color: white; padding: 1rem 2rem; border-radius: 2rem; z-index: 10001; animation: fadeInUp 0.5s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3); font-weight: 600; text-align: center;";
                        toast.innerHTML = `<i class="fa-solid fa-check-circle"></i> ${data.message}`;
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 4000);

                        // 2. Update Points
                        currentPoints = data.newPoints;
                        const pointDisplay = document.getElementById('userPointsDisplay');
                        if (pointDisplay) {
                            pointDisplay.textContent = data.newPoints.toLocaleString() + ' Pts';
                        }
                        
                        // 3. Update Individual Stock Labels
                        itemsToUpdate.forEach(item => {
                            const stockEl = document.getElementById(`stock-qty-${item.id}`);
                            if (stockEl) {
                                // Extract current number
                                const currentText = stockEl.textContent;
                                const match = currentText.match(/Available: (\d+)/);
                                if (match) {
                                    const newStock = Math.max(0, parseInt(match[1]) - item.quantity);
                                    stockEl.textContent = `Available: ${newStock} items left`;
                                }
                            }
                        });

                        // 3. Update Notification Badge IMMEDIATELY (Zero Latency)
                        if (data.unread_count !== undefined) {
                            const notiBadge = document.getElementById('notiBadge');
                            if (notiBadge) {
                                notiBadge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                                notiBadge.style.display = data.unread_count > 0 ? 'flex' : 'none';
                            }
                        }

                        // 4. Trigger background notification list fetch
                        if (typeof window.fetchNotifications === 'function') {
                            window.fetchNotifications();
                        }
                        
                        // 5. Reset UI State
                        const receiptItems = [...exchangeCart];
                        exchangeCart = [];
                        updateExchangeUI();
                        closeExchangeModal();

                        // 6. Show Receipt
                        showExchangeReceipt(data, receiptItems);
                        
                        // 7. Refresh order button states Site-wide
                        document.querySelectorAll('.redeem-btn').forEach(btn => {
                            const onclickAttr = btn.getAttribute('onclick');
                            const match = onclickAttr.match(/,\s*(\d+),\s*'/);
                            if (match) {
                                const ptsReq = parseInt(match[1]);
                                if (ptsReq > currentPoints) {
                                    btn.disabled = true;
                                }
                            }
                        });

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

        // --- Post-Transaction Receipt Logic ---
        const receiptModalOverlay = document.getElementById('receiptModalOverlay');
        const exchangeReceiptModal = document.getElementById('exchangeReceiptModal');
        const closeReceiptModal = document.getElementById('closeReceiptModal');

        function showExchangeReceipt(data, items) {
            const receiptOrderId = document.getElementById('receiptOrderId');
            const receiptDate = document.getElementById('receiptDate');
            const receiptPointsSpent = document.getElementById('receiptPointsSpent');
            const receiptItemsList = document.getElementById('receiptItemsList');

            if (receiptOrderId) receiptOrderId.textContent = `#${data.exchange_id || 'EXCH' + Date.now().toString().slice(-4)}`;
            if (receiptDate) receiptDate.textContent = new Date().toLocaleString('en-US', { 
                month: 'short', day: '2-digit', year: 'numeric', 
                hour: '2-digit', minute: '2-digit', hour12: true 
            });
            
            const totalPoints = items.reduce((sum, item) => sum + (item.points * item.quantity), 0);
            if (receiptPointsSpent) receiptPointsSpent.textContent = totalPoints.toLocaleString() + ' Pts';

            if (receiptItemsList) {
                receiptItemsList.innerHTML = items.map(item => `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span style="color: #333;">${item.name} <span style="color: #999; font-size: 0.8rem;">x${item.quantity}</span></span>
                        <span style="font-weight: 500; color: #dc2626;">-${(item.points * item.quantity).toLocaleString()} Pts</span>
                    </div>
                `).join('');
            }

            if (receiptModalOverlay && exchangeReceiptModal) {
                receiptModalOverlay.classList.add('active');
                exchangeReceiptModal.classList.add('active');
            }
        }

        if (closeReceiptModal) {
            closeReceiptModal.onclick = () => {
                if (receiptModalOverlay && exchangeReceiptModal) {
                    receiptModalOverlay.classList.remove('active');
                    exchangeReceiptModal.classList.remove('active');
                    location.reload();
                }
            };
        }
    </script>
    <script src="assets/js/home.view.js"></script>
    <!-- Post-Transaction Receipt Modal -->
    <div class="modal-overlay" id="receiptModalOverlay" style="z-index: 10002;">
        <div class="modal" id="exchangeReceiptModal" style="max-width: 450px; width: 95%; padding: 0; background: #fff; overflow: hidden;">
            <div style="background: var(--cozy-green); color: white; padding: 1.5rem; text-align: center;">
                <h3 style="margin: 0; font-size: 1.25rem;">Exchange Receipt</h3>
                <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; opacity: 0.9;">Cozy Sip Rewards Program</p>
            </div>
            <div style="padding: 1.5rem; background: #fff;">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-gift" style="font-size: 2.5rem; color: #4ade80;"></i>
                    <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: #333;">Redemption Successful!</p>
                </div>
                
                <div style="border-bottom: 1px dashed #ddd; margin-bottom: 1rem; padding-bottom: 0.8rem; font-size: 0.85rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="color: #666;">Transaction ID:</span>
                        <span id="receiptOrderId" style="font-weight: 600;">#EXCH001</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
                        <span style="color: #666;">Date:</span>
                        <span id="receiptDate">--</span>
                    </div>
                </div>

                <div id="receiptItemsList" style="margin-bottom: 1rem; max-height: 200px; overflow-y: auto;">
                    <!-- Items will be injected here -->
                </div>

                <div style="border-top: 1px solid #eee; padding-top: 1rem; margin-top: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600; color: #333;">Total Points Spent:</span>
                        <span id="receiptPointsSpent" style="font-weight: 700; color: #dc2626; font-size: 1.1rem;">0 Pts</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #004225;">
                        <span style="font-weight: 500;">Status:</span>
                        <span style="font-weight: 600;">Redeemed</span>
                    </div>
                </div>
            </div>
            <div style="padding: 1.5rem; padding-top: 0; text-align: center;">
                <p style="margin: 0 0 1.5rem 0; font-size: 0.75rem; color: #999; line-height: 1.4;">
                    Your items are ready for pickup. <br> Show this receipt to our staff!
                </p>
                <button id="closeReceiptModal" style="width: 100%; padding: 0.8rem; background: var(--cozy-green); color: white; border: none; border-radius: 0.8rem; font-weight: 600; cursor: pointer;">Great, Thanks!</button>
            </div>
        </div>
    </div>
</body>
</html>
