<?php
// Weka ulinzi na anzisha session juu kabisa ya ukurasa kabla ya HTML yoyote
require_once 'includes/auth.php';
redirect_if_authenticated(); // Kama ashalog-in, mpeleke index.php moja kwa moja
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="light-mode">

    <div class="theme-toggle" id="themeToggleBtn">
        <i class="fa-solid fa-gear"></i>
    </div>

    <div class="login-container">
        <div class="tab-container">
            <button class="tab-btn active">Login</button>
            <button class="tab-btn">Sign Up</button>
        </div>

        <h2>Login</h2>

        <?php if (isset($_GET['error'])): ?>
            <div style="padding: 12px; background: #f8d7da; color: #721c24; border-radius: 15px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; font-weight: bold; box-shadow: var(--shadow-out);">
                <?php 
                    if ($_GET['error'] == 'invalid_credentials') {
                        echo "Email au Password sio sahihi! ❌";
                    } elseif ($_GET['error'] == 'empty_fields') {
                        echo "Tafadhali jaza nafasi zote! ⚠️";
                    } else {
                        echo "Kuna tatizo limejitokeza. Jaribu tena.";
                    }
                ?>
            </div>
        <?php endif; ?>

        <form action="modules/users/auth_process.php" method="POST">
            <div class="input-group">
                <i class="fa-regular fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="password" id="passwordField" placeholder="Password" required>
                <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        <div class="social-text">Or continue with:</div>

        <div class="social-container">
            <a href="#" class="social-btn"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="social-btn"><i class="fa-brands fa-google"></i></a>
            <a href="#" class="social-btn"><i class="fa-brands fa-github"></i></a>
        </div>

        <div class="designer-credit">
            Computer Science Group Assignment
        </div>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            document.body.classList.toggle('light-mode');
        });

        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('passwordField');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>