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
                   <a href="login.view.php" class="login-btn-outline">Login</a>
                </div>
            </div>
        </div>

        <div class="register-form-side">
            <form action="index.php?page=register_process" method="POST" class="auth-form">
                <h1 class="form-heading">Create Account</h1>

                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="example@mail.com" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required>
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