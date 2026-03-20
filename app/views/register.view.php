<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="register-page">

    <div class="notification-container" id="notificationContainer">
        <div class="notification-box" id="notificationBox">
            <span class="notification-icon" id="notificationIcon"></span>
            <span class="notification-message" id="notificationMessage"></span>
        </div>
    </div>

    <div class="register-wrapper">

        <div class="register-info-side">
            <div class="info-content">
                <h2 class="info-title">Get Started</h2>
                <p class="info-text">Join Cozy Sip today and elevate your wellness with the perfect tea.</p>
                <div class="login-redirect">
                    <p>Already have an account?</p>
                   <a href="index.php?page=login" class="login-btn-outline">Login</a>
                </div>
            </div>
        </div>

        <div class="register-form-side">
            <form action="index.php?page=register_process" method="POST" class="auth-form">
                <h1 class="form-heading">Create Account</h1>
                <p class="form-subtext">Create your account to start ordering</p>

                <?php 
                $session_error = null;
                if (isset($_SESSION['errors'])) {
                    $session_error = implode(" ", $_SESSION['errors']);
                    unset($_SESSION['errors']);
                }

                $session_success = null;
                if (isset($_SESSION['success'])) {
                    $session_success = $_SESSION['success'];
                    unset($_SESSION['success']);
                }
                ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('notificationContainer');
                        const box = document.getElementById('notificationBox');
                        const icon = document.getElementById('notificationIcon');
                        const message = document.getElementById('notificationMessage');

                        function showNotification(msg, type) {
                            message.textContent = msg;
                            box.className = 'notification-box ' + type;
                            icon.innerHTML = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-exclamation"></i>';
                            
                            container.classList.add('active');
                            
                            setTimeout(() => {
                                container.classList.remove('active');
                            }, 5000);
                        }

                        <?php if ($session_error): ?>
                            showNotification("<?php echo addslashes($session_error); ?>", 'error');
                        <?php endif; ?>

                        <?php if ($session_success): ?>
                            showNotification("<?php echo addslashes($session_success); ?>", 'success');
                            setTimeout(function() {
                                window.location.href = "index.php?page=home";
                            }, 3000);
                        <?php endif; ?>
                    });
                </script>

                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="John Doe" pattern="[A-Za-z\s]+" title="Please enter only English letters and spaces" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="example@mail.com" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Password" minlength="9" required>
                        <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" minlength="9" required>
                        <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                    </div>
                </div>

                <button type="submit" class="signup-btn">SignUp</button>
            </form>
        </div>

    </div>
    <script src="assets/js/register.view.js"></script>
</body>

</html>