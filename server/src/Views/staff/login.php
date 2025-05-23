<?php
session_start();

//require_once __DIR__ . '/../../Utils/Security.php';
//require_once __DIR__ . '/../../Utils/Validator.php';
//require_once __DIR__ . '/../../Services/AuthService.php';

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Theater Aurora</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #E74C3C;
            --accent-color: #3498DB;
            --background-color: #ECF0F1;
            --text-color: #2C3E50;
            --error-color: #E74C3C;
            --success-color: #27AE60;
            --input-background: #FFFFFF;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: var(--input-background);
            border-radius: 10px;
            box-shadow: 0 8px 24px var(--shadow-color);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .theater-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .theater-logo i {
            font-size: 3rem;
            color: var(--accent-color);
        }

        .theater-logo h1 {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--input-background);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group i {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: #A0AEC0;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
        }

        .forgot-password {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color);
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            background-color: var(--accent-color);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #2980B9;
            transform: translateY(-1px);
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .alert-success {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(39, 174, 96, 0.2);
        }

        .password-toggle {
            cursor: pointer;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-color);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="theater-logo">
            <i class="fas fa-theater-masks"></i>
            <h1>Theater Aurora</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="/staff/authenticate" method="POST" id="loginForm">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required 
                       autocomplete="email" autofocus
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                <i class="fas fa-envelope"></i>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye password-toggle"></i>
            </div>

            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password" id="forgotPasswordLink">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal" id="forgotPasswordModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Reset Password</h2>
            <p>Enter your email address to receive a password reset link.</p>
            <form action="/staff/reset-password" method="POST" id="resetPasswordForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                    <label for="reset-email">Email</label>
                    <input type="email" id="reset-email" name="email" required>
                    <i class="fas fa-envelope"></i>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordInput = document.querySelector('#password');

            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Modal handling
            const modal = document.getElementById('forgotPasswordModal');
            const forgotPasswordLink = document.getElementById('forgotPasswordLink');
            const closeModal = document.querySelector('.close-modal');

            forgotPasswordLink.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.add('active');
            });

            closeModal.addEventListener('click', function() {
                modal.classList.remove('active');
            });

            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });

            // Form validation
            const loginForm = document.getElementById('loginForm');
            const resetPasswordForm = document.getElementById('resetPasswordForm');

            loginForm.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    e.preventDefault();
                    alert('Please fill in all fields');
                }
            });

            resetPasswordForm.addEventListener('submit', function(e) {
                const resetEmail = document.getElementById('reset-email').value;

                if (!resetEmail) {
                    e.preventDefault();
                    alert('Please enter your email address');
                }
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>