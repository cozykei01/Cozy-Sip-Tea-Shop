<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.view.css">
</head>

<body class="login-page">

    <div class="login-wrapper">

        <div class="login-info-side">
            <div class="info-content">
                <h2 class="info-title">New Here?</h2>
                <p class="info-text">Sign up and discover a great amount of new opportunities!</p>
                <div class="register-redirectရ">
                    <p>Don't have an account?</p>
                    <a href="index.php?page=register" class="register-btn-outline">Sign Up</a>
                </div>
            </div>
        </div>

        <div class="login-form-side">
            <form action="index.php?page=login_process" method="POST" class="auth-form">
                <h1 class="form-heading">Welcome Back!</h1>
                <p class="form-subtext">Login to your account to continue</p>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="error-messages" style="background: #fee2e2; color: #dc2626; padding: 0.8rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.9rem;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></p>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['errors']); ?>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <div class="label-row">
                        <label>Email</label>
                    </div>
                    <input type="email" name="email" placeholder="example@mail.com" required>
                </div>

                <div class="input-group">
                    <div class="label-row">
                        <label>Password</label>
                        <a href="index.php?page=forgot_password" class="forgot-link">Forgot pw?</a>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="login-pw" placeholder="••••••••" required>
                        <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword('login-pw', this)"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>

    </div>

    <script src="assets/js/login.view.js"></script>
</body>

</html>