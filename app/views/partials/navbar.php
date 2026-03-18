<!-- Navbar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php?page=home" class="logo">
            <i class="fa-solid fa-mug-hot"></i> Cozy Sip
        </a>
        
        <ul class="nav-links">
            <li><a href="index.php?page=home" class="<?php echo ($activePage === 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="index.php?page=menu" class="<?php echo ($activePage === 'menu') ? 'active' : ''; ?>">Menu</a></li>
            <li><a href="index.php?page=exchange" class="<?php echo ($activePage === 'exchange') ? 'active' : ''; ?>">Exchange</a></li>
            <li><a href="#" class="<?php echo ($activePage === 'about') ? 'active' : ''; ?>">About</a></li>
            <li><a href="#" class="<?php echo ($activePage === 'contact') ? 'active' : ''; ?>">Contact</a></li>
        </ul>

        <div class="user-actions">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="point-balance">
                    <i class="fa-solid fa-leaf"></i> <span id="userPointsDisplay"><?php echo number_format($_SESSION['user_points'] ?? 0); ?> Pts</span>
                </div>
                <button class="noti-btn" aria-label="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span class="noti-badge">3</span>
                </button>
                <div class="profile-container" style="position: relative;">
                    <button class="profile-btn" id="profileDropdownBtn" style="background:none; border:none; padding:0; cursor:pointer;">
                        <div class="profile-img">
                            <img src="assets/image/default_avatar.png" alt="Profile">
                        </div>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-header">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                            <span class="user-email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?></span>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa-regular fa-user"></i> My Profile</a></li>
                            <li class="logout-item"><a href="index.php?page=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons" style="display: flex; gap: 1rem; align-items: center;">
                    <a href="index.php?page=login" style="text-decoration: none; color: #fff; font-weight: 600;">Login</a>
                    <a href="index.php?page=register" style="text-decoration: none; background: #e6b325; color: #0b2611; padding: 0.5rem 1.2rem; border-radius: 2rem; font-weight: 600;">Join Now</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
