<?php
$activePage = 'profile';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Cozy Sip Tea Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        /* --- Force Navbar Centering --- */
        .nav-profile-container, .profile-btn, .nav-profile-img {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
        }
        .nav-profile-img img {
            width: 42px !important;
            height: 42px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            border: 2px solid var(--cozy-gold) !important;
        }

        /* --- New Profile Layout --- */
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto 5rem;
            padding: 0 2rem;
        }

        .profile-header-card {
            background: white;
            border-radius: 2rem;
            display: grid;
            grid-template-columns: 350px 1fr;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            border: 1px solid #eee;
        }

        .profile-card-left {
            background: linear-gradient(135deg, var(--cozy-dark) 0%, var(--cozy-green) 100%);
            padding: 3rem 2rem;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .profile-card-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
        }

        .avatar-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
            z-index: 5;
        }

        .profile-avatar-large {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid var(--cozy-gold);
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            position: relative;
        }

        .profile-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 42px;
            height: 42px;
            background: var(--cozy-gold);
            color: var(--cozy-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: all 0.3s;
            z-index: 20;
        }

        .avatar-upload-btn:hover {
            transform: scale(1.1);
            background: #f0bd2d;
        }

        .avatar-upload-btn i {
            font-size: 1.1rem;
        }

        .profile-name {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .profile-badge {
            display: inline-block;
            background: var(--cozy-gold);
            color: var(--cozy-dark);
            padding: 0.4rem 1.2rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.85rem;
            margin-top: 0.8rem;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .profile-card-right {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* --- Info Grid --- */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-group { margin-bottom: 0; }
        .info-label { font-size: 0.8rem; color: #888; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
        .info-value { font-size: 1.15rem; font-weight: 600; color: var(--cozy-dark); margin-top: 4px; }

        .points-summary {
            background: #f1f8f5;
            border-radius: 1.5rem;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #d6e8e0;
        }

        .points-text h3 { margin: 0; font-size: 0.9rem; color: #666; text-transform: uppercase; }
        .points-text .points-large { font-size: 2.2rem; font-weight: 800; color: var(--cozy-green); margin-top: 2px; }
        
        .exchange-link {
            background: var(--cozy-green);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .exchange-link:hover { background: var(--cozy-green-light); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        /* --- History Section --- */
        .history-card {
            background: white;
            border-radius: 2rem;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid #eee;
        }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--cozy-green);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .tabs { display: flex; gap: 1.5rem; margin-bottom: 2.5rem; border-bottom: 2px solid #f0f0f0; }
        .tab-btn { 
            background: none; border: none; padding: 1rem 0; cursor: pointer; color: #888; 
            font-weight: 700; font-size: 1.1rem; position: relative; transition: all 0.3s;
        }
        .tab-btn.active { color: var(--cozy-green); }
        .tab-btn.active::after {
            content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
            height: 3px; background: var(--cozy-green); border-radius: 3px;
        }

        .history-item {
            display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 1rem;
            background: #fff; border-radius: 0.8rem; border: 1px solid #f0f0f0; margin-bottom: 0.5rem;
            transition: all 0.3s;
        }
        .history-item:hover { transform: translateX(5px); border-color: var(--cozy-green); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        
        .history-info h4 { margin: 0; color: var(--cozy-dark); font-size: 0.95rem; }
        .history-date { font-size: 0.75rem; color: #888; margin-top: 1px; display: block; }
        
        .history-amount { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 1px; }
        .amount-value { font-weight: 800; font-size: 0.95rem; color: var(--cozy-dark); }
        .amount-pts { color: var(--cozy-green); font-size: 0.75rem; font-weight: 700; }
        .status-badge { 
            font-size: 0.65rem; padding: 0.15rem 0.5rem; border-radius: 2rem; 
            background: #e6f7ef; color: #10b981; font-weight: 700; text-transform: uppercase;
        }

        .history-list {
            max-height: 440px;
            overflow-y: auto;
            padding-right: 10px;
            display: flex;
            flex-direction: column;
        }

        /* Custom Scrollbar */
        .history-list::-webkit-scrollbar {
            width: 6px;
        }
        .history-list::-webkit-scrollbar-track {
            background: #f8fbf9;
            border-radius: 10px;
        }
        .history-list::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
            transition: background 0.3s;
        }
        .history-list::-webkit-scrollbar-thumb:hover {
            background: var(--cozy-green-light);
        }

        @media (max-width: 992px) {
            .profile-header-card { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; gap: 1rem; }
            .profile-card-right { padding: 2rem; }
        }

        /* --- Edit Modal Styles --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(5px);
            z-index: 1000; display: none; align-items: center; justify-content: center;
        }
        .modal-content {
            background: white; width: 90%; max-width: 500px; padding: 2.5rem;
            border-radius: 2rem; box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            position: relative; animation: modalSlideUp 0.4s ease;
        }
        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .modal-header h3 { margin: 0; font-family: 'Outfit', sans-serif; font-size: 1.5rem; color: var(--cozy-green); }
        .close-modal-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #888; transition: color 0.3s; }
        .close-modal-btn:hover { color: #555; }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 700; color: #666; margin-bottom: 8px; text-transform: uppercase; }
        .form-group input { 
            width: 100%; padding: 0.9rem 1.2rem; border-radius: 1rem; border: 2px solid #eee;
            font-family: inherit; font-size: 1rem; transition: all 0.3s;
        }
        .form-group input:focus { border-color: var(--cozy-green); outline: none; box-shadow: 0 0 0 4px rgba(11, 38, 17, 0.05); }
        
        .save-btn {
            width: 100%; padding: 1rem; background: var(--cozy-green); color: white;
            border: none; border-radius: 1rem; font-weight: 800; font-size: 1rem;
            cursor: pointer; transition: all 0.3s; margin-top: 1rem;
        }
        .save-btn:hover { background: var(--cozy-green-light); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(11, 38, 17, 0.15); }

        .edit-profile-btn {
            background: #f0f7f3; color: var(--cozy-green); border: none; padding: 0.5rem 1rem;
            border-radius: 2rem; font-size: 0.85rem; font-weight: 700; cursor: pointer;
            transition: all 0.3s; display: flex; align-items: center; gap: 0.5rem;
        }
        .edit-profile-btn:hover { background: var(--cozy-green); color: white; }
    </style>
</head>
<body>
    <?php include 'partials/navbar.php'; ?>

    <div class="profile-container">
        <!-- Header Section -->
        <header class="profile-header-card">
            <div class="profile-card-left">
                <div class="avatar-wrapper">
                    <div class="profile-avatar-large" id="profileAvatarContainer">
                        <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'assets/image/default_avatar.png'; ?>" alt="Profile" id="profileDisplayImg">
                    </div>
                    <div class="avatar-upload-btn" onclick="document.getElementById('profileInput').click()" title="Change Profile Picture">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <input type="file" id="profileInput" style="display: none;" accept="image/*">
                </div>
                <h1 class="profile-name"><?php echo htmlspecialchars($user['full_name']); ?></h1>
            </div>
            
            <div class="profile-card-right">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 class="section-title" style="margin-bottom: 0;"><i class="fa-solid fa-circle-info"></i> Account Details</h3>
                    <button class="edit-profile-btn" id="openEditModalBtn"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</button>
                </div>
                
                <div class="info-grid">
                    <div class="info-group">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value" id="displayContact"><?php echo htmlspecialchars($user['contact'] ?? 'Not provided'); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Role</div>
                        <div class="info-value"><?php echo ucfirst(htmlspecialchars($user['role'] ?? 'Member')); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Member Since</div>
                        <div class="info-value"><?php echo date('M d, Y', strtotime($user['created_at'] ?? 'now')); ?></div>
                    </div>
                </div>

                <div class="points-summary">
                    <div class="points-text">
                        <h3>Point Balance</h3>
                        <div class="points-large"><i class="fa-solid fa-leaf"></i> <?php echo number_format($user['point_balance']); ?></div>
                    </div>
                    <a href="index.php?page=exchange" class="exchange-link">Exchange Products <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </header>

        <!-- History Section -->
        <section class="history-card">
            <h3 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Activity History</h3>
            
            <div class="tabs">
                <button class="tab-btn active" id="ordersTabBtn">Order History</button>
                <button class="tab-btn" id="exchangesTabBtn">Exchange History</button>
                <button class="tab-btn" id="favoritesTabBtn">My Favorites</button>
            </div>

            <!-- Orders List -->
            <div id="ordersContent" class="history-list">
                <?php if (empty($orders)): ?>
                    <div style="text-align: center; padding: 3rem 0; width: 100%;">
                        <i class="fa-solid fa-mug-hot" style="font-size: 3.5rem; color: #eee; margin-bottom: 1.5rem; display: block;"></i>
                        <p style="color: #888; font-size: 1.1rem;">No orders found yet. Ready to try our premium teas?</p>
                        <a href="index.php?page=menu" style="display:inline-block; margin-top: 1.5rem; background: var(--cozy-green); color: white; padding: 0.8rem 2rem; border-radius: 2rem; text-decoration: none; font-weight: 700;">Browse Menu</a>
                    </div>
                <?php else: ?>
                    <div style="width: 100%;">
                    <?php foreach ($orders as $order): ?>
                        <div class="history-item">
                            <div class="history-info">
                                <h4>Order #<?php echo $order['order_id']; ?></h4>
                                <span class="history-date"><?php echo date('M d, Y | h:i A', strtotime($order['order_date'])); ?></span>
                            </div>
                            <div class="history-amount">
                                <span class="amount-value"><?php echo number_format($order['total_amount'], 0); ?> Ks</span>
                                <span class="amount-pts">+<?php echo number_format($order['earned_points']); ?> Pts</span>
                                <span class="status-badge">Completed</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Exchanges List -->
            <div id="exchangesContent" class="history-list" style="display: none;">
                <?php if (empty($exchanges)): ?>
                    <div style="text-align: center; padding: 3rem 0; width: 100%;">
                        <i class="fa-solid fa-gift" style="font-size: 3.5rem; color: #eee; margin-bottom: 1.5rem; display: block;"></i>
                        <p style="color: #888; font-size: 1.1rem;">No exchanges yet. Earn more points for free rewards!</p>
                        <a href="index.php?page=menu" style="display:inline-block; margin-top: 1.5rem; border: 2px solid var(--cozy-green); color: var(--cozy-green); padding: 0.8rem 2rem; border-radius: 2rem; text-decoration: none; font-weight: 700;">Earn Points</a>
                    </div>
                <?php else: ?>
                    <div style="width: 100%;">
                    <?php foreach ($exchanges as $exchange): ?>
                        <div class="history-item">
                            <div class="history-info">
                                <h4><?php echo htmlspecialchars($exchange['product_name']); ?> (x<?php echo $exchange['quantity'] ?? 1; ?>)</h4>
                                <span class="history-date"><?php echo date('M d, Y | h:i A', strtotime($exchange['exchange_date'])); ?></span>
                            </div>
                            <div class="history-amount">
                                <span class="amount-value" style="color: #e6b325;">-<?php echo number_format($exchange['points_spent']); ?> Pts</span>
                                <span class="status-badge" style="background: #fdf5e6; color: #e6b325;">Redeemed</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Favorites List -->
            <div id="favoritesContent" class="history-list" style="display: none;">
                <?php if (empty($favorites)): ?>
                    <div style="text-align: center; padding: 3rem 0; width: 100%;">
                        <i class="fa-solid fa-heart-crack" style="font-size: 3.5rem; color: #eee; margin-bottom: 1.5rem; display: block;"></i>
                        <p style="color: #888; font-size: 1.1rem;">Your favorite list is empty. Heart some items!</p>
                        <a href="index.php?page=menu" style="display:inline-block; margin-top: 1.5rem; background: var(--cozy-green); color: white; padding: 0.8rem 2rem; border-radius: 2rem; text-decoration: none; font-weight: 700;">Explore Menu</a>
                    </div>
                <?php else: ?>
                    <div style="width: 100%;">
                    <?php foreach ($favorites as $fav): ?>
                        <?php 
                            $img = 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&q=80&w=500'; // Default
                            $name = strtolower($fav['product_name']);
                            if (strpos($name, 'espresso') !== false) $img = 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?auto=format&fit=crop&q=80&w=500';
                            if (strpos($name, 'americano') !== false) $img = 'https://images.unsplash.com/photo-1551030173-122aabc4489c?auto=format&fit=crop&q=80&w=500';
                            if (strpos($name, 'latte') !== false) $img = 'https://images.unsplash.com/photo-1570968915860-54d5c301fa9f?auto=format&fit=crop&q=80&w=500';
                            if (strpos($name, 'cappuccino') !== false || strpos($name, 'macchiato') !== false) $img = 'https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=500';
                        ?>
                        <div class="history-item" id="fav-item-<?php echo $fav['product_id']; ?>">
                            <div class="history-info" style="display: flex; align-items: center; gap: 1rem;">
                                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($fav['product_name']); ?>" style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover;">
                                <div>
                                    <h4><?php echo htmlspecialchars($fav['product_name']); ?></h4>
                                    <span class="history-date">Added on <?php echo date('M d, Y', strtotime($fav['favorited_at'])); ?></span>
                                </div>
                            </div>
                            <div class="history-amount">
                                <span class="amount-value"><?php echo number_format($fav['price'], 0); ?> Ks</span>
                                <button class="remove-fav-btn" data-id="<?php echo $fav['product_id']; ?>" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 0.9rem; margin-top: 5px; font-weight: 600;">
                                    <i class="fa-solid fa-trash-can"></i> Remove
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editModalOverlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Profile</h3>
                <button class="close-modal-btn" id="closeEditModalBtn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="editProfileForm">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="editFullName" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" id="editContact" value="<?php echo htmlspecialchars($user['contact'] ?? ''); ?>" placeholder="e.g., 09xxxxxxxxx">
                </div>
                <button type="submit" class="save-btn" id="saveProfileBtn">Save Changes</button>
            </form>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="assets/js/home.view.js"></script>
    <script>
        const ordersTabBtn = document.getElementById('ordersTabBtn');
        const exchangesTabBtn = document.getElementById('exchangesTabBtn');
        const favoritesTabBtn = document.getElementById('favoritesTabBtn');
        const ordersContent = document.getElementById('ordersContent');
        const exchangesContent = document.getElementById('exchangesContent');
        const favoritesContent = document.getElementById('favoritesContent');

        ordersTabBtn.onclick = () => {
            ordersTabBtn.classList.add('active');
            exchangesTabBtn.classList.remove('active');
            favoritesTabBtn.classList.remove('active');
            ordersContent.style.display = 'flex';
            exchangesContent.style.display = 'none';
            favoritesContent.style.display = 'none';
        };

        exchangesTabBtn.onclick = () => {
            exchangesTabBtn.classList.add('active');
            ordersTabBtn.classList.remove('active');
            favoritesTabBtn.classList.remove('active');
            exchangesContent.style.display = 'flex';
            ordersContent.style.display = 'none';
            favoritesContent.style.display = 'none';
        };

        favoritesTabBtn.onclick = () => {
            favoritesTabBtn.classList.add('active');
            ordersTabBtn.classList.remove('active');
            exchangesTabBtn.classList.remove('active');
            favoritesContent.style.display = 'flex';
            ordersContent.style.display = 'none';
            exchangesContent.style.display = 'none';
        };

        // Profile Image Upload
        const profileInput = document.getElementById('profileInput');
        const profileDisplayImg = document.getElementById('profileDisplayImg');
        const navProfileImg = document.querySelector('.nav-profile-img img');

        profileInput.onchange = function() {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append('profile_image', this.files[0]);

                fetch('index.php?page=upload_profile_image', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update both images
                        profileDisplayImg.src = data.image_path;
                        if (navProfileImg) navProfileImg.src = data.image_path;
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during upload.');
                });
            }
        };

        // Profile Edit Modal
        const editModalOverlay = document.getElementById('editModalOverlay');
        const openEditModalBtn = document.getElementById('openEditModalBtn');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editProfileForm = document.getElementById('editProfileForm');
        const saveProfileBtn = document.getElementById('saveProfileBtn');

        const profileNameDisplay = document.querySelector('.profile-name');
        const fullNameValueDisplay = document.querySelectorAll('.info-value')[1]; // Second info-value is Full Name or Contact? 
        // Let's use IDs for info values for more reliability
        const contactValueDisplay = document.getElementById('displayContact');
        const fullNameInGrid = document.getElementById('displayFullName'); // Wait, I need to add these IDs

        openEditModalBtn.onclick = () => {
            editModalOverlay.style.display = 'flex';
        };

        const closeEditModal = () => {
            editModalOverlay.style.display = 'none';
        };

        closeEditModalBtn.onclick = closeEditModal;
        editModalOverlay.onclick = (e) => {
            if (e.target === editModalOverlay) closeEditModal();
        };

        editProfileForm.onsubmit = (e) => {
            e.preventDefault();
            
            const fullName = document.getElementById('editFullName').value;
            const contact = document.getElementById('editContact').value;
            
            saveProfileBtn.disabled = true;
            saveProfileBtn.textContent = 'Saving...';

            fetch('index.php?page=update_profile', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    full_name: fullName,
                    contact: contact
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    profileNameDisplay.textContent = data.full_name;
                    if (document.getElementById('displayFullName')) {
                        document.getElementById('displayFullName').textContent = data.full_name;
                    }
                    if (document.getElementById('displayContact')) {
                        document.getElementById('displayContact').textContent = data.contact || 'Not provided';
                    }
                    
                    // Update Navbar name
                    const navUserName = document.querySelector('.user-name'); 
                    if (navUserName) navUserName.textContent = data.full_name;

                    alert(data.message);
                    closeEditModal();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating profile.');
            })
            .finally(() => {
                saveProfileBtn.disabled = false;
                saveProfileBtn.textContent = 'Save Changes';
            });
        };

        // Remove favorite functionality
        document.querySelectorAll('.remove-fav-btn').forEach(btn => {
            btn.onclick = function() {
                const productId = this.dataset.id;
                const itemRow = document.getElementById(`fav-item-${productId}`);

                if (confirm('Remove this item from your favorites?')) {
                    fetch('index.php?page=favorite_toggle', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ productId: productId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (itemRow) {
                                itemRow.style.opacity = '0';
                                setTimeout(() => itemRow.remove(), 300);
                            }
                            // Show toast notification
                            if (typeof showToast === 'function') {
                                showToast(data.message, 'fa-trash-can');
                            }
                            // Refresh system notifications
                            if (typeof window.fetchNotifications === 'function') {
                                window.fetchNotifications();
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(err => console.error('Error removing favorite:', err));
                }
            };
        });
    </script>
</body>
</html>
