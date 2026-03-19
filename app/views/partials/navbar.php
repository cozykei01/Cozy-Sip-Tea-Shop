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
                <div class="nav-noti-container" style="position: relative;">
                    <button class="noti-btn" id="notiDropdownBtn" aria-label="Notifications">
                        <i class="fa-solid fa-bell"></i>
                        <span class="noti-badge" id="notiBadge">0</span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div class="noti-dropdown" id="notiDropdown">
                        <div class="noti-header">
                            <h3>Notifications</h3>
                            <button class="mark-read-btn" id="markAllReadBtn">Mark all as read</button>
                        </div>
                        <div class="noti-list" id="notiList">
                            <div class="noti-empty">
                                <i class="fa-solid fa-bell-slash"></i>
                                No new notifications
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-profile-container">
                    <button class="profile-btn" id="profileDropdownBtn">
                        <div class="nav-profile-img">
                            <img src="<?php echo !empty($_SESSION['user_profile_img']) ? htmlspecialchars($_SESSION['user_profile_img']) : 'assets/image/default_avatar.png'; ?>" alt="User Profile">
                        </div>
                        <i class="fa-solid fa-chevron-down profile-chevron"></i>
                    </button>
                    
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown" id="profileDropdown">
                        <div class="dropdown-header">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                            <span class="user-email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?></span>
                        </div>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?page=profile"><i class="fa-regular fa-user"></i> My Profile</a></li>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notiBtn = document.getElementById('notiDropdownBtn');
    const notiDropdown = document.getElementById('notiDropdown');
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    const notiList = document.getElementById('notiList');
    const notiBadge = document.getElementById('notiBadge');

    if (notiBtn) {
        // Toggle Dropdown
        notiBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notiDropdown.classList.toggle('active');
            
            // Close profile dropdown if open
            const profileDropdown = document.getElementById('profileDropdown');
            if (profileDropdown) profileDropdown.classList.remove('active');
        });

        // Close on click outside
        document.addEventListener('click', function(e) {
            if (!notiDropdown.contains(e.target) && e.target !== notiBtn) {
                notiDropdown.classList.remove('active');
            }
        });

        // Mark all as read
        markAllReadBtn.addEventListener('click', function() {
            fetch('index.php?page=mark_notifications_read')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        notiBadge.style.display = 'none';
                        notiBadge.textContent = '0';
                        fetchNotifications(); // Refresh list
                    }
                });
        });

        // Initial fetch
        fetchNotifications();
        
        // Refresh every 10 seconds
        setInterval(fetchNotifications, 10000);

        // Expose globally for AJAX actions (like order confirm)
        window.fetchNotifications = fetchNotifications;
    }

    function fetchNotifications() {
        fetch('index.php?page=get_notifications')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update Badge
                    const count = data.unread_count;
                    if (count > 0) {
                        notiBadge.textContent = count > 9 ? '9+' : count;
                        notiBadge.style.display = 'flex';
                    } else {
                        notiBadge.style.display = 'none';
                    }

                    // Update List
                    if (data.notifications.length > 0) {
                        notiList.innerHTML = data.notifications.map(noti => `
                            <div class="noti-item ${noti.is_read == 0 ? 'unread' : ''}">
                                <div class="noti-icon">
                                    <i class="fa-solid ${noti.title.includes('Payment') ? 'fa-wallet' : 'fa-bell'}"></i>
                                </div>
                                <div class="noti-details">
                                    <span class="noti-title">${noti.title}</span>
                                    <span class="noti-msg">${noti.message}</span>
                                    <span class="noti-time">${formatTime(noti.created_at)}</span>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        notiList.innerHTML = `
                            <div class="noti-empty">
                                <i class="fa-solid fa-bell-slash"></i>
                                No notifications yet
                            </div>`;
                    }
                }
            });
    }

    function formatTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + 'm ago';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + 'h ago';
        
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }
});
</script>
