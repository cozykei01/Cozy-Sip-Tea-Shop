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
                if (isset($_SESSION['errors'])): ?>
                    <div class="error-messages" style="background: #fee2e2; color: #dc2626; padding: 0.8rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.9rem;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errors']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="success-message" id="successMsg" style="background: #dcfce7; border: 1px solid #22c55e; color: #15803d; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                        <p><i class="fa-solid fa-circle-check"></i> <?php echo $_SESSION['success']; ?></p>
                        <p style="font-size: 0.75rem; margin-top: 0.25rem;">Redirecting to home in 3 seconds...</p>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "index.php?page=home";
                        }, 3000);
                    </script>
                <?php endif; ?>

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
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
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