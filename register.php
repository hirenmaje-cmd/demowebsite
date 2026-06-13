<?php
session_start();
require_once 'db.php';

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $country = trim($_POST['country']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Double check uniqueness constraint
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $message = "Username or Email already registered.";
            $status = "error";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, country) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $phone, $country);
            
            if ($stmt->execute()) {
                $message = "Registration successful! Proceeding to Login.";
                $status = "success";
                echo "<script>setTimeout(function(){ window.location.href = 'login.php'; }, 2000);</script>";
            } else {
                $message = "An unexpected error occurred.";
                $status = "error";
            }
            $stmt->close();
        }
        $check->close();
    } else {
        $message = "Please complete all mandatory parameters.";
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRG Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background:#000; overflow:hidden; }
        .main-container { width:100%; height:100vh; display:flex; }
        
        /* Left Side Banner Panel */
        .left-side { width:50%; position:relative; overflow:hidden; }
        .left-side img { width:100%; height:100%; object-fit:cover; }
        .left-side::after { content:''; position:absolute; top:0; right:0; width:250px; height:100%; background:linear-gradient(to right, rgba(0,0,0,0), rgba(8,9,13,1)); }
        
        /* Right Side Form Deck */
        .right-side { width:50%; background:#08090d; padding:40px 80px; color:white; overflow-y: auto; display: flex; flex-direction: column; justify-content: center; position: relative; }
        
        /* Arabic Lang Switcher */
        .lang-switch { position: absolute; top: 30px; right: 40px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 500; }
        
        /* Brand Head */
        .logo-container { text-align: center; margin-bottom: 20px; }
        .logo-container h2 { font-size: 36px; font-weight: 800; color: #ffffff; letter-spacing: 1px; }
        .logo-container h2 span { color: #ff7a00; }
        
        .sign-title { text-align:center; color:#ffffff; margin-bottom:30px; font-size:18px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Input Layout Wrappers */
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; margin-bottom:8px; color:#ff7a00; font-weight:500; font-size:13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width:100%; height:50px; border:1px solid #1f232b; border-radius:8px; background:#0f1115; color:white; padding:0 20px; font-size:14px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #ff7a00; background: #13151f; }
        
        /* Checkbox Terms styling */
        .checkbox-group { margin-top: 5px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .checkbox-group input { width: 18px; height: 18px; accent-color: #ff7a00; cursor: pointer; margin-top: 2px; }
        .checkbox-label { color: #8f8f8f; font-size: 13px; line-height: 1.4; font-weight: 400; }
        .checkbox-label a { color: #ff7a00; text-decoration: none; font-weight: 500; }
        .checkbox-label a:hover { text-decoration: underline; }

        /* Actions Submit Customization */
        .btn-submit { width:100%; height:52px; background:#ff7a00; border:none; border-radius:8px; color:black; font-weight:700; font-size:16px; cursor:pointer; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 5px; }
        .btn-submit:hover { background:#e0531c; color: white; box-shadow: 0 4px 15px rgba(255,122,0,0.3); }
        
        .form-footer { text-align:center; margin-top:25px; color:#8f8f8f; font-size: 14px; }
        .form-footer a { color:#ff7a00; text-decoration:none; font-weight:600; margin-left: 5px; }
        .form-footer a:hover { text-decoration: underline; }
        
        /* Status Dynamic Notification Overlays */
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center; }
        .alert-error { background: rgba(255, 77, 77, 0.1); border: 1px solid #ff4d4d; color: #ff4d4d; }
        .alert-success { background: rgba(0, 230, 118, 0.1); border: 1px solid #00e676; color: #00e676; }

        /* Responsive Matrix System */
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
            
            <div class="sign-title">Create Account</div>
            
            <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $status === 'error' ? 'error' : 'success'; ?>">
                    <?php if($status === 'error'): ?><i class="fa-solid fa-circle-exclamation"></i><?php else: ?><i class="fa-solid fa-circle-check"></i><?php endif; ?>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Choose your unique username" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email address" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create your secure password" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="Enter your contact line (Optional)">
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" placeholder="Enter your region location">
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="termsCheck" required>
                    <label for="termsCheck" class="checkbox-label">
                        I have read and accepted the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.
                    </label>
                </div>
                
                <button type="submit" class="btn-submit">Register</button>
                
                <div class="form-footer">
                    Already have an account? <a href="login.php">Login Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>