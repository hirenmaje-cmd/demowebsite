<?php
session_start();
require_once 'db.php';

// If user is already logged in, redirect straight to dashboard index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifies securely against password_hash
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Invalid password entry.";
            }
        } else {
            $error_message = "No account found with that email address.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRG Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#000; overflow:hidden; }
        .main-container { width:100%; height:100vh; display:flex; }
        
        /* Left Side Banner Image */
        .left-side { width:50%; position:relative; overflow:hidden; }
        .left-side img { width:100%; height:100%; object-fit:cover; }
        .left-side::after { content:''; position:absolute; top:0; right:0; width:250px; height:100%; background:linear-gradient(to right, rgba(0,0,0,0), rgba(8,9,13,1)); }
        
        /* Right Side Login Desk */
        .right-side { width:50%; background:#08090d; padding:40px 80px; color:white; overflow-y: auto; display: flex; flex-direction: column; justify-content: center; position: relative; }
        
        /* Arabic Lang Switcher */
        .lang-switch { position: absolute; top: 30px; right: 40px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 500; }
        
        /* Brand Identity */
        .logo-container { text-align: center; margin-bottom: 25px; }
        .logo-container h2 { font-size: 36px; font-weight: 800; color: #ffffff; letter-spacing: 1px; }
        .logo-container h2 span { color: #ff7a00; }
        
        .sign-title { text-align:center; color:#ffffff; margin-bottom:20px; font-size:16px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Social Media Container Layout */
        .social-login { display: flex; justify-content: center; gap: 15px; margin-bottom: 30px; }
        .social-btn { width: 65px; height: 50px; background: #13151f; border: 1px solid #1f232b; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; color: #ffffff; font-size: 20px; }
        .social-btn:hover { background: #ff7a00; color: #000; border-color: #ff7a00; }
        .social-btn.google-wide { width: 140px; }
        .social-btn img { height: 22px; width: auto; object-fit: contain; }
        
        /* Custom Native Divider Rule */
        .or-divider { display: flex; align-items: center; text-align: center; margin-bottom: 25px; color: #4e5564; }
        .or-divider::before, .or-divider::after { content: ''; flex: 1; border-bottom: 1px solid #1f232b; }
        .or-divider:not(:empty)::before { margin-right: .75em; }
        .or-divider:not(:empty)::after { margin-left: .75em; }
        .or-divider span { font-size: 14px; font-weight: 500; color: #8f8f8f; }

        /* Structured Inputs */
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:8px; color:#ff7a00; font-weight:500; font-size:14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width:100%; height:52px; border:1px solid #1f232b; border-radius:8px; background:#0f1115; color:white; padding:0 20px; font-size:15px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #ff7a00; background: #13151f; }
        
        /* Forgot Link Options */
        .forgot-link-container { text-align: right; margin-top: -10px; margin-bottom: 25px; }
        .forgot-link-container a { color: #8f8f8f; text-decoration: none; font-size: 13px; transition: 0.3s; }
        .forgot-link-container a:hover { color: #ff7a00; }

        /* Native Buttons */
        .btn-submit { width:100%; height:52px; background:#ff7a00; border:none; border-radius:8px; color:black; font-weight:700; font-size:16px; cursor:pointer; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-submit:hover { background:#e0531c; color: white; box-shadow: 0 4px 15px rgba(255,122,0,0.3); }
        
        .form-footer { text-align:center; margin-top:30px; color:#8f8f8f; font-size: 14px; }
        .form-footer a { color:#ff7a00; text-decoration:none; font-weight:600; margin-left: 5px; }
        .form-footer a:hover { text-decoration: underline; }
        
        /* Server Warning Alert Bars */
        .error-alert { background: rgba(255, 77, 77, 0.1); border: 1px solid #ff4d4d; color: #ff4d4d; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center; }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .left-side { display: none; }
            .right-side { width: 100%; padding: 40px 30px; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="left-side">
            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1000" alt="Esports Gaming Asset">
        </div>
        
        <div class="right-side">
            <a href="#" class="lang-switch">العربية</a>
            
            <div class="logo-container">
                <h2>PRG<span>.</span></h2>
            </div>
            
            <div class="sign-title">Sign in with</div>
            
            <div class="social-login">
                <div class="social-btn"><i class="fa-brands fa-discord"></i></div>
                <div class="social-btn"><i class="fa-brands fa-twitch"></i></div>
                <div class="social-btn google-wide">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google">
                </div>
            </div>
            
            <div class="or-divider">
                <span>Or</span>
            </div>
            
            <?php if(!empty($error_message)): ?>
                <div class="error-alert"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="forgot-link-container">
                    <a href="#">Forgot your password?</a>
                </div>
                
                <button type="submit" class="btn-submit">Sign In</button>
                
                <div class="form-footer">
                    Don't have an account? <a href="register.php">Register Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>