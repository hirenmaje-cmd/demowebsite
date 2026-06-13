<?php
session_start();

// Agar user logged in nahi hai, toh use zabardasti index1.php (first page) par bhej do
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php");
    exit();
}

// Security wall: Kick unauthenticated sessions out to the login interface instantly
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GT ESPORT - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0c0c0e; color: #ffffff; padding-top: 90px; font-family: system-ui, sans-serif; overflow-x: hidden; }
        
        /* Navigation Styles */
        header { background: #111114; padding: 15px 40px; position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; border-bottom: 1px solid #1f1f25; }
        .logo img { width: 110px; height: auto; }
        nav { display: flex; gap: 8px; align-items: center; }
        nav a { color: #bcbcc4; text-decoration: none; padding: 10px 16px; font-weight: 500; font-size: 0.95rem; transition: all 0.2s; }
        nav a.active, nav a:hover { color: #ff7a00; }
        
        .dropdown { position: relative; }
        .dropdown-content { display: none; position: absolute; top: 100%; left: 0; min-width: 200px; background: #16161a; border: 1px solid #232329; border-radius: 6px; overflow: hidden; box-shadow: 0 8px 16px rgba(0,0,0,0.5); }
        .dropdown-content a { display: block; padding: 12px 16px; color: #e1e1e6; }
        .dropdown-content a:hover { background: #ff7a00; color: #fff; }
        .dropdown:hover .dropdown-content { display: block; }
        
        .search-container { position: relative; width: 240px; }
        .search-container input { width: 100%; background: #18181c; border: 1px solid #2d2d35; border-radius: 6px; padding: 8px 35px 8px 12px; color: #fff; font-size: 0.9rem; }
        .search-container i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #62626a; }
        
        .nav-actions { display: flex; align-items: center; gap: 20px; justify-content: flex-end; }
        .icon-btn { color: #a1a1a8; font-size: 1.2rem; cursor: pointer; transition: color 0.2s; }
        .icon-btn:hover { color: #ff7a00; }
        .avatar-pill { width: 36px; height: 36px; background: #ff7a00; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; text-transform: uppercase; }

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
            box-shadow: 0 10px 25px rgba(0,0,0,0.7);
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
        .user-menu-dropdown .logout-link {
            color: #ff4d4d;
        }
        .user-menu-dropdown .logout-link:hover {
            color: #ff3333;
        }

        /* Shared Side Panels Styles (Chat & General Notifications) */
        .chat-notifications-panel, .general-notifications-panel {
            position: fixed;
            top: 0;
            right: -360px; /* Initially hidden */
            width: 360px;
            height: 100vh;
            background: #18181b;
            box-shadow: -5px 0 25px rgba(0,0,0,0.8);
            z-index: 10005;
            padding: 95px 25px 30px 25px;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }
        .chat-notifications-panel.show, .general-notifications-panel.show {
            right: 0;
        }
        .panel-sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 30px;
        }
        .notification-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #232329;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .notification-item-row:hover {
            opacity: 0.85;
        }
        .notification-item-left {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #e4e4e7;
        }
        .notification-item-left i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        .notification-item-row .fa-chevron-down {
            font-size: 0.8rem;
            color: #71717a;
        }
        
        /* Custom Specific Icon Colors */
        .color-tournament { color: #f97316; }
        .color-royale { color: #f59e0b; }
        .color-ladders { color: #f59e0b; }
        .color-scrim { color: #ea580c; }
        .color-coaching { color: #f97316; }
        .color-gray-icon { color: #a1a1a8; }

        /* Dashboard Master Grid Layout */
        .dashboard-container { display: grid; grid-template-columns: 280px 1fr 300px; gap: 20px; padding: 25px 40px; max-width: 1800px; margin: 0 auto; }
        
        /* Sidebars Shared Configuration */
        .widget-panel { background: #141417; border: 1px solid #1f1f24; border-radius: 10px; padding: 20px; }
        .panel-heading { color: #ff7a00; font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        
        /* Left Column User Information Metrics */
        .user-profile-summary { text-align: center; margin-bottom: 25px; border-bottom: 1px solid #1f1f24; padding-bottom: 20px; }
        .summary-avatar { width: 75px; height: 75px; background: #26262b; border-radius: 50%; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; border: 2px solid #ff7a00; }
        .summary-avatar i { font-size: 2rem; color: #a1a1a8; }
        .summary-name { font-weight: 700; font-size: 1.1rem; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .geo-tag { background: #222; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; color: #aaa; text-transform: uppercase; }
        
        .metric-row { display: flex; justify-content: space-between; padding: 11px 0; border-bottom: 1px solid #1a1a1e; font-size: 0.9rem; }
        .metric-row:last-child { border: none; }
        .metric-label { color: #7e7e86; }
        .metric-val { font-weight: 600; }
        .metric-val.highlight { color: #00e676; font-weight: 700; }
        .metric-val.credits { color: #ff7a00; }

        /* Action Menu Buttons inside Left Panel */
        .action-list { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
        .btn-action-panel { background: #1a1a1f; border: 1px solid #26262d; color: #fff; padding: 12px; border-radius: 8px; font-weight: 600; text-align: left; display: flex; justify-content: space-between; align-items: center; text-decoration: none; font-size: 0.9rem; }
        .btn-action-panel:hover { border-color: #ff7a00; color: #ff7a00; }
        .btn-orange-add { background: #ff7a00; color: white; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; }

        /* Center Grid Feature Slider */
        .main-hero-banner { background: linear-gradient(90deg, #09090b 20%, rgba(0,0,0,0.4) 100%), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200'); background-size: cover; background-position: center; border-radius: 12px; height: 380px; padding: 50px; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #1f1f24; position: relative; }
        .hero-title-group h1 { font-size: 4rem; line-height: 0.95; font-weight: 900; letter-spacing: -1px; }
        .hero-footer-cta { display: flex; justify-content: space-between; align-items: flex-end; }
        .cta-tagline p { color: #ffff00; font-size: 1.1rem; font-weight: 800; letter-spacing: 1px; margin-bottom: 2px; }
        .slider-arrows { position: absolute; top: 30px; right: 40px; display: flex; gap: 10px; }
        .arrow-btn { width: 36px; height: 36px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; }
        .arrow-btn:hover { background: #ff7a00; border-color: #ff7a00; }

        /* Right Coach Cards and Tournaments panels */
        .coach-card { background: #1a1a1f; border-radius: 8px; overflow: hidden; border: 1px solid #232329; margin-bottom: 20px; }
        .coach-card img { width: 100%; height: auto; display: block; }
        .coach-meta { padding: 15px; color: #3498db; font-size: 1.1rem; font-weight: 700; display: flex; justify-content: space-between; align-items: center; }
        
        .premium-upgrade-box { background: linear-gradient(135deg, #1b120a 0%, #141417 100%); border: 1px solid #3d230b; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 20px; color: #ff8c00; font-weight: bold; font-size: 0.9rem; cursor: pointer; display: block; text-decoration: none; }
        .premium-upgrade-box:hover { border-color: #ff8c00; }

        .placeholder-text { padding: 25px 10px; color: #62626a; font-size: 0.9rem; text-align: center; }
        .btn-view-yellow { width: 100%; padding: 12px; background: #ffb300; border: none; border-radius: 6px; font-weight: 700; color: #000; font-size: 0.9rem; cursor: pointer; transition: background 0.2s; }
        .btn-view-yellow:hover { background: #ffa200; }

        /* Footer Element Rules */
        footer { background: #070709; padding: 60px 40px 30px; border-top: 1px solid #141417; margin-top: 60px; color: #7e7e86; }
        .footer-grid { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 40px; max-width: 1600px; margin: 0 auto; }
        .footer-brand { max-width: 280px; }
        .footer-brand img { width: 130px; margin-bottom: 20px; }
        .footer-brand p { font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; }
        .social-row { display: flex; gap: 15px; }
        .social-row i { font-size: 1.4rem; color: #4e4e56; cursor: pointer; transition: color 0.2s; }
        .social-row i:hover { color: #ff7a00; }
        .footer-links-col h3 { color: #ff7a00; font-size: 1rem; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; }
        .footer-links-col a { display: block; color: #8e8e96; text-decoration: none; margin-bottom: 12px; font-size: 0.9rem; }
        .footer-links-col a:hover { color: #ff7a00; }
        .footer-copyright { text-align: center; margin-top: 50px; padding-top: 25px; border-top: 1px solid #131317; font-size: 0.85rem; color: #4e4e56; }

        @media(max-width: 1200px) {
            .dashboard-container { grid-template-columns: 1fr; }
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
                     <a href="index.php" class="active">Home</a>
                     <div class="dropdown">
                         <a href="#">Play <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.75rem;"></i></a>
                         <div class="dropdown-content">
                             <a href="#">Leaderboard Matches</a>
                             <a href="#">Tournament</a>
                         </div>
                     </div>
                     <a href="#">Shop</a>
                     <a href="createteam.php">Create Team</a>
                     <div class="dropdown">
                         <a href="#">More <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.75rem;"></i></a>
                         <div class="dropdown-content">
                             <a href="#">Find Team</a>
                             <a href="#">Leaderboard</a>
                             <a href="#">Teams</a>
                         </div>
                     </div>
                 </nav>
             </div>

             <div class="col-6 col-md-4 text-end">
                <div class="nav-actions">
                    <div class="search-container d-none d-lg-block">
                        <input type="text" placeholder="Search Players...">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    
                    <i class="fa-solid fa-comment-dots icon-btn" id="chatNotificationBtn" title="Chats"></i>
                    <i class="fa-solid fa-bell icon-btn" id="generalNotificationBtn" title="Notifications"></i>
                    
                    <div class="user-dropdown-container" style="position: relative;">
                        <div class="avatar-pill" id="avatarBtn" style="cursor: pointer;" title=" aria-haspopup="true" aria-expanded="false">
<?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        </div>
                        
                        <div class="user-menu-dropdown" id="userDropdown" role="menu" aria-labelledby="avatarBtn" >
                            <div class="dropdown-header-user"> 
                                <i class="fa-solid fa-circle-user"></i>
                                <span class="dropdown-username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            </div>
                            
                            <div class="dropdown-credits-row">
                                <span>🪙 0</span>
                                <span>💵 0</span>
                                <a href="#" class="btn-buy-credits">Buy Credits</a>
                            </div>
                            
                            <hr class="dropdown-divider">
                            
                            <div class="dropdown-section-title">My Profile</div>
                            <a href="#" role="menuitem"><i class="fa-solid fa-user"></i> View Profile</a>
                            <a href="#" role="menuitem"><i class="fa-solid fa-pen"></i> Edit Profile</a>
                            <a href="#" role="menuitem"><i class="fa-solid fa-ticket"></i> My Tickets</a>
                            <a href="#" role="menuitem"><i class="fa-solid fa-users"></i> My Referrals</a>
                            
                            <hr class="dropdown-divider">
                            
                            <div class="dropdown-section-title">Transactions</div>
                            <a href="#" role="menuitem"><i class="fa-solid fa-clock-rotate-left"></i> Transaction History</a>
                            <a href="#" role="menuitem"><i class="fa-solid fa-bolt"></i> My Boosts</a>
                            <a href="#" role="menuitem"><i class="fa-solid fa-wallet"></i> Cashout Earnings</a>
                            
                            <hr class="dropdown-divider">
                            
                            <div class="dropdown-section-title">Languages</div>
                            <a href="#" class="lang-option" role="menuitem">العربية</a>
                            
                            <hr class="dropdown-divider">
                            
                            <a href="logout.php" class="logout-link" role="menuitem"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
</header>

<div class="chat-notifications-panel" id="chatNotificationPanel">
    <div class="panel-sidebar-title">Chat Notifications</div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-trophy color-tournament"></i>
            <span>Tournament Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-crown color-royale"></i>
            <span>Battle Royale Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-bars color-ladders"></i>
            <span>Ladders Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-gavel color-scrim"></i>
            <span>Scrim Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-chalkboard-user color-coaching"></i>
            <span>Coaching Sessions</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
</div>

<div class="general-notifications-panel" id="generalNotificationPanel">
    <div class="panel-sidebar-title">Notifications</div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-users color-gray-icon"></i>
            <span>Team Invites</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-user-group color-gray-icon"></i>
            <span>Substitute Invites</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-user-plus color-gray-icon"></i>
            <span>Friend Requests</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-trophy color-gray-icon"></i>
            <span>Tournament Invites</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-trophy color-gray-icon"></i>
            <span>Tournament Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-chart-simple color-gray-icon"></i>
            <span>Ladder Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-crown color-gray-icon"></i>
            <span>Battle Royals</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-people-group color-gray-icon"></i>
            <span>Scrim Teams</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-user-tie color-gray-icon"></i>
            <span>Coach Scrims</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-handshake color-gray-icon"></i>
            <span>Scrim Matches</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
    
    <div class="notification-item-row">
        <div class="notification-item-left">
            <i class="fa-solid fa-calendar-check color-gray-icon"></i>
            <span>Coach Bookings</span>
        </div>
        <i class="fa-solid fa-chevron-down"></i>
    </div>
</div>

<div class="dashboard-container">
    
   <div class="left-panel-wrapper">
    <div class="widget-panel">
        <div class="user-profile-summary">
            <div class="summary-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="summary-name">
                <?php echo htmlspecialchars($user['username'] ?? 'User', ENT_QUOTES, 'UTF-8'); ?>
                <span class="geo-tag" title="<?php echo htmlspecialchars($flag_title ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($user['nationality'] ?? 'Global', ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>

        <div class="metrics-list">
            <div class="metric-row">
                <span class="metric-label">Joined</span>
                <span class="metric-val text-success"><?php echo (int)($minutes_online ?? 0); ?> minutes ago</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Credits</span>
                <span class="metric-val credits">0</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Rank</span>
                <span class="metric-val text-warning">Novice</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Current Earnings</span>
                <span class="metric-val highlight">$0.00</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Matches Won</span>
                <span class="metric-val">0</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">XP</span>
                <span class="metric-val">0</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Global Rank</span>
                <span class="metric-val text-warning">#3,476</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Win Rate</span>
                <span class="metric-val">0%</span>
            </div>
            <div class="metric-row">
                <span class="metric-label">Trophies</span>
                <span class="metric-val"><i class="fa-solid fa-trophy text-secondary"></i> 0 <i class="fa-solid fa-medal text-secondary ms-1"></i> 0</span>
            </div>
        </div>
    </div>

    <div class="action-list">
        <a href="#" class="btn-action-panel">
            <span>My Teams (0)</span>
            <span class="btn-orange-add"><i class="fa-solid fa-plus"></i></span>
        </a>
        <a href="#" class="btn-action-panel">
            <span>Joined Tournaments (0)</span>
        </a>
        <a href="#" class="btn-action-panel">
            <span>Friends List (0)</span>
            <i class="fa-solid fa-user-plus text-secondary"></i>
        </a>
    </div>
</div>

<div class="center-content-wrapper">
    <div class="main-hero-banner">
        <div class="slider-arrows">
            <div class="arrow-btn"><i class="fa-solid fa-chevron-left"></i></div>
            <div class="arrow-btn"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
        
        <div class="hero-title-group">
            <h1>FOLLOW US ON<br>OUR SOCIALS</h1>
        </div>
        
        <div class="hero-footer-cta">
            <div class="cta-tagline">
                <p>BECOME PART OF THE PRG FAMILY</p>
            </div>
        </div>
    </div>
</div>

<div class="right-panel-wrapper">
    <div class="widget-panel mb-3">
        <div class="panel-heading">
            <i class="fa-solid fa-screwdriver-wrench"></i> Top Coaches
        </div>
        <div class="coach-card">
            <img src="img/Dlong_Nov.png" alt="Coach Dlong" onerror="this.src='https://images.unsplash.com/photo-1560169897-fc0cdbdfa4d5?w=400';">
            <div class="coach-meta">
                <span><i class="fa-solid fa-circle text-success" style="font-size:0.6rem;"></i> jiren</span>
                <div class="d-flex gap-2 text-white" style="font-size:0.8rem;">
                    <div class="arrow-btn" style="width:24px; height:24px;"><i class="fa-solid fa-chevron-left" style="font-size:0.6rem;"></i></div>
                    <div class="arrow-btn" style="width:24px; height:24px;"><i class="fa-solid fa-chevron-right" style="font-size:0.6rem;"></i></div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="premium-upgrade-box">
        <i class="fa-solid fa-crown me-2"></i> Become an Elite Member
    </a>

    <div class="widget-panel">
        <div class="dropdown-toggle d-none"></div>
        <div class="panel-heading">
            <i class="fa-solid fa-crown"></i> Elite Tournaments
        </div>
        <div class="placeholder-text">
            No elite tournaments found
        </div>
        <button class="btn-view-yellow">View All Tournaments</button>
    </div>
</div>

</div>

<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <img src="img/prg.jpg" alt="PRG Logo">
            <p>Competitive gaming platform for players of all skill levels.</p>
            <div class="social-row">
                <i class="fab fa-discord"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-steam"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-twitch"></i>
                <i class="fab fa-youtube"></i>
            </div>
        </div>
        <div class="footer-links-col">
            <h3>Play</h3>
            <a href="#">Tournaments</a>
            <a href="#">Ladders Matches</a>
            <a href="#">Leaderboard</a>
            <a href="#">Teams</a>
        </div>
        <div class="footer-links-col">
            <h3>Support</h3>
            <a href="#">FAQ</a>
            <a href="#">Support Ticket</a>
        </div>
        <div class="footer-links-col">
            <h3>Legal</h3>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Guidelines</a>
        </div>
        <div class="footer-links-col">
            <h3>Work With Us</h3>
            <a href="#">Advertisement</a>
            <a href="mailto:info@playrivalsgaming.com">info@playrivalsgaming.com</a>
            <a href="#">Host Tournament</a>
        </div>
    </div>
    <div class="footer-copyright">
        © 2026 Play Rivals Gaming LLC. All rights reserved.
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements Fetching
    const avatarBtn = document.getElementById('avatarBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    const chatBtn = document.getElementById('chatNotificationBtn');
    const chatPanel = document.getElementById('chatNotificationPanel');
    
    const generalBtn = document.getElementById('generalNotificationBtn');
    const generalPanel = document.getElementById('generalNotificationPanel');

    // 1. User Avatar Dropdown Toggle
    avatarBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        // Close side panels if open
        chatPanel.classList.remove('show');
        generalPanel.classList.remove('show');
        // Toggle Dropdown
        userDropdown.classList.toggle('show');
    });

    // 2. Chat Sidebar Panel Toggle
    chatBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.remove('show');
        generalPanel.classList.remove('show');
        chatPanel.classList.toggle('show');
    });

    // 3. General Notifications Sidebar Panel Toggle
    generalBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.remove('show');
        chatPanel.classList.remove('show');
        generalPanel.classList.toggle('show');
    });

    // 4. Close everything when clicking outside
    document.addEventListener('click', function() {
        userDropdown.classList.remove('show');
        chatPanel.classList.remove('show');
        generalPanel.classList.remove('show');
    });

    // 5. Prevent auto-closing when clicking inside active dropdown or sidebars
    userDropdown.addEventListener('click', function(e) { e.stopPropagation(); });
    chatPanel.addEventListener('click', function(e) { e.stopPropagation(); });
    generalPanel.addEventListener('click', function(e) { e.stopPropagation(); });
});
</script>
</body>
</html>