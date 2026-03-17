<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/profile.view.css">
    <link rel="stylesheet" href="../../public/assets/css/sidebar-navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="profile-page">
    <div class="main-layout">
        <?php include 'partials/sidebar.php'; ?>

        <main class="main-content">
            <?php include 'partials/nav.php'; ?>

            <div class="profile-container">
                <div class="profile-card profile-main">
                    <div class="profile-header">
                        <div class="image-wrapper">
                            <img src="../../public/assets/image/User default pfp.png" alt="Profile Image">
                            <button class="upload-btn"><i class="fas fa-camera"></i></button>
                        </div>
                        <h3>My Profile</h3>
                    </div>

                    <div class="info-list">
                        <div class="info-group">
                            <label>Name</label>
                            <p>John Doe</p>
                        </div>
                        <div class="info-group">
                            <label>Role</label>
                            <p>Customer</p>
                        </div>
                        <div class="info-group">
                            <label>Member Since</label>
                            <p>March 17, 2026</p>
                        </div>
                        <div class="info-group">
                            <label>Email</label>
                            <p>johndoe@gmail.com</p>
                        </div>
                        <div class="info-group">
                            <label>Phone Number</label>
                            <div class="status-wrapper">
                                <p>+959 123 456 789</p>
                                <span class="status-tag active">Active</span>
                            </div>
                        </div>
                    </div>
                    <button class="save-btn">Save Changes</button>
                </div>

                <div class="profile-side-column">
                    <div class="profile-card point-balance">
                        <h3>Point Balance</h3>
                        <div class="points">
                            <i class="fas fa-coins"></i>
                            <span>1,250 Points</span>
                        </div>
                    </div>

                    <div class="profile-card empty-box">
                        <h3>Recent Activity</h3>
                        <div class="placeholder-content">
                            <p>No recent activity found.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>