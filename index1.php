<?php
session_start();
// If user is already logged in, bypass this landing page and take them to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRG Gaming</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font
awesome/6.6.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0c0c0e;
            color: #ffffff;
            padding-top: 90px;
            font-family: system-ui, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation Styles */
        header {
            background: #111114;
            padding: 15px 40px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            border-bottom: 1px solid #1f1f25;
        }

        .logo img {
            width: 110px;
            height: auto;
        }

        nav {
            display: flex;
            gap: 8px;
            align-items: center;
        }


        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            background: #16161a;
            border: 1px solid #232329;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        .dropdown-content a {
            display: block;
            padding: 12px 16px;
            color: #e1e1e6;
        }

        .dropdown-content a:hover {
            background: #ff7a00;
            color: #fff;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .search-container {
            position: relative;
            width: 240px;
        }

        .search-container input {
            width: 100%;
            background: #18181c;
            border: 1px solid #2d2d35;
            border-radius: 6px;
            padding: 8px 35px 8px 12px;
            color: #fff;
            font-size: 0.9rem;
        }

        .search-container i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #62626a;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            justify-content: flex-end;
        }

        .icon-btn {
            color: #a1a1a8;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .icon-btn:hover {
            color: #ff7a00;
        }

        .avatar-pill {
            width: 36px;
            height: 36px;
            background: #ff7a00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        /* User Menu Dropdown Styles */
        .user-menu-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 260px;
            background: #141417;
            border: 1px solid #232329;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.7);
            padding: 15px;
            text-align: left;
            z-index: 10000;
        }

        .user-menu-dropdown.show {
            display: block;
        }

        .dropdown-header-user {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            margin-bottom: 10px;
        }

        .dropdown-credits-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .btn-buy-credits {
            background: transparent;
            border: 1px solid #ff7a00;
            color: #ff7a00;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-buy-credits:hover {
            background: #ff7a00;
            color: #fff;
        }

        .dropdown-section-title {
            color: #7e7e86;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 10px 0 6px 0;
        }

        .user-menu-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #bcbcc4;
            text-decoration: none;
            padding: 8px 0;
            font-size: 0.88rem;
            transition: color 0.2s;
        }

        .user-menu-dropdown a:hover {
            color: #ff7a00;
        }

        .user-menu-dropdown .dropdown-divider {
            border-color: #232329;
            margin: 8px 0;
            opacity: 1;
        }

        .logo h1 {
            color: #ff8c00;
            font-size: 42px;
        }

        .logo span {
            font-size: 11px;
            color: #fff;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            transition: .3s;
        }

        nav a.active {
            background: #ff8c00;
        }

        nav a:hover {
            background: #ff8c00;
        }

        .login-btn {
            background: #ff8c00;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
         
        }

        /* MAIN */

        .main {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        /* BANNER */

        .banner {
            flex: 3;
            height: 460px;
            background: linear-gradient(rgba(0, 0, 0, .3), rgba(0, 0, 0, .5)),
                url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .banner-content {
            padding: 50px;
        }

        .banner-content h1 {
            font-size: 80px;
            line-height: 80px;
        }

        .prize {
            position: absolute;
            right: 40px;
            bottom: 40px;
            text-align: right;
        }

        .prize p {
            color: #ffff00;
            font-size: 28px;
            font-weight: bold;
        }

        .prize h2 {
            color: #ffb300;
            font-size: 70px;
        }

        /* RIGHT SIDEBAR */

        .sidebar {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background: #101010;
            border: 1px solid #222;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-title {
            color: #ff8c00;
            padding: 15px;
            border-bottom: 1px solid #222;
            font-size: 20px;
        }

        .card img {
            width: 100%;
            display: block;
        }

        .coach {
            padding: 15px;
            color: #3498db;
            font-size: 18px;
        }

        .empty {
            padding: 30px 20px;
            color: #aaa;
        }

        .view-btn {
            width: 90%;
            margin: 15px auto;
            display: block;
            border: none;
            background: #ffb300;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        /* FOOTER */

        footer {
            background: #080808;
            margin-top: 40px;
            padding: 50px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 30px;
        }

        .footer-box h3,
        .footer-box h4 {
            color: #ff8c00;
            margin-bottom: 15px;
        }

        .footer-box p,
        .footer-box a {
            display: block;
            color: #bdbdbd;
            text-decoration: none;
            margin-bottom: 10px;
        }

        /* MOBILE */

        @media(max-width:1000px) {

            header {
                flex-direction: column;
                gap: 20px;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .main {
                flex-direction: column;
            }

            footer {
                grid-template-columns: 1fr 1fr;
            }

            .banner-content h1 {
                font-size: 45px;
                line-height: 50px;
            }

            .prize h2 {
                font-size: 40px;
            }
        }
        .a{
            color: white;
        }
    </style>
</head>

<body>

    <header>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6 col-md-2">
                    <div class="logo">
                        <img src="img/prg.jpg" alt="PRG Logo">
                    </div>
                </div>

                <div class="col-md-6 d-none d-md-block">
                    <nav>
                        <a href="site.php" class="active">Home</a>
                        <div class="dropdown">
                            <a href="#">Play <i class="fa-solid fa-chevron-down ms-1"
                                    style="font-size:0.75rem;"></i></a>
                            <div class="dropdown-content">
                                <a href="#">Leaderboard Matches</a>
                                <a href="#">Tournament</a>
                            </div>
                        </div>
                        <a href="#">Shop</a>
                        <a href="createteam.php">Create Team</a>
                        <div class="dropdown">
                            <a href="#">More <i class="fa-solid fa-chevron-down ms-1"
                                    style="font-size:0.75rem;"></i></a>
                            <div class="dropdown-content">
                                <a href="#">Find Team</a>
                                <a href="#">Leaderboard</a>
                                <a href="#">Teams</a>
                            </div>
                        </div>
                    </nav>
                </div>
                
                <div class="col-3"></div>
                <div class="col-1">
                    <button class="login-btn"><a href="login.php" style="text-decoration: none;" class="a">login</a></button>
                </div>
            </div>
        </div>

        </div>
        </div>
    </header>


    <div class="main">

        <div class="banner">

            <div class="banner-content">
                <h1>
                    CLASH<br>
                    LEGENDS<br>
                    CUP
                </h1>
            </div>

            <div class="prize">
                <p>REGISTER NOW!</p>
                <h2>5,000 INR</h2>
            </div>

        </div>

        <div class="sidebar">

            <div class="card">
                <div class="card-title">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Top Coaches
                </div>

                <img src="img/Dlong_Nov.png" alt="Coach">

                <div class="coach">
                    bsportjoshh
                </div>
            </div>

            <div class="card">

                <div class="card-title">
                    <i class="fa-solid fa-crown"></i>
                    Elite Tournaments
                </div>

                <div class="empty">
                    No elite tournaments found
                </div>

                <button class="view-btn">
                    View All Tournaments
                </button>

            </div>

        </div>

    </div>

    <footer>

        <div class="footer-box">
            <h3>PRG</h3>
            <p>Competitive gaming platform for players of all skill levels.</p>
        </div>

        <div class="footer-box">
            <h4>Play</h4>
            <a href="#">Tournaments</a>
            <a href="#">Ladder Matches</a>
            <a href="#">Leaderboard</a>
            <a href="#">Teams</a>
        </div>

        <div class="footer-box">
            <h4>Support</h4>
            <a href="#">FAQ</a>
            <a href="#">Support</a>
        </div>

        <div class="footer-box">
            <h4>Legal</h4>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Halal Guidelines</a>
        </div>

        <div class="footer-box">
            <h4>Work With Us</h4>
            <p>info@playrivalsgaming.com</p>
            <p>Host Tournament</p>
            <p>PRG Academy</p>
        </div>

    </footer>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>