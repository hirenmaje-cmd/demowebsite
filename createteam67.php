<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GT ESPORT - Create Team</title>
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
        .avatar-pill { width: 36px; height: 36px; background: #ff7a00; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; cursor: pointer; }

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
        .user-menu-dropdown.show { display: block; }
        .dropdown-header-user { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.95rem; color: #fff; margin-bottom: 10px; }
        .dropdown-credits-row { display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; margin-bottom: 15px; }
        .btn-buy-credits { background: transparent; border: 1px solid #ff7a00; color: #ff7a00; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; text-decoration: none; font-weight: 600; }
        .btn-buy-credits:hover { background: #ff7a00; color: #fff; }
        .dropdown-section-title { color: #7e7e86; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin: 10px 0 6px 0; }
        .user-menu-dropdown a { display: flex; align-items: center; gap: 10px; color: #bcbcc4; text-decoration: none; padding: 8px 0; font-size: 0.88rem; transition: color 0.2s; }
        .user-menu-dropdown a:hover { color: #ff7a00; }
        .user-menu-dropdown .dropdown-divider { border-color: #232329; margin: 8px 0; opacity: 1; }
        .user-menu-dropdown .logout-link { color: #ff4d4d; }
        .user-menu-dropdown .logout-link:hover { color: #ff3333; }

        /* Shared Side Panels Styles (Chat & General Notifications) */
        .chat-notifications-panel, .general-notifications-panel {
            position: fixed;
            top: 0;
            right: -360px;
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
        .dashboard-container { display: grid; grid-template-columns: 280px 1fr; gap: 30px; padding: 25px 40px; max-width: 1800px; margin: 0 auto; }
        
        /* Widget configuration */
        .widget-panel { background: #141417; border: 1px solid #1f1f24; border-radius: 10px; padding: 20px; }
        
        /* Left Column User Profile Info */
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
        .btn-action-panel { background: #1a1a1f; border: 1px solid #26262d; color: #fff; padding: 12px; border-radius: 8px; font-weight: 600; text-align: left; display: flex; justify-content: space-between; align-items: center; text-decoration: none; font-size: 0.9rem; width: 100%; cursor: pointer;}
        .btn-action-panel:hover { border-color: #ff7a00; color: #ff7a00; }
        .btn-orange-add { background: #ff7a00; color: white; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; }

        /* My Teams Dropdown Container */
        .my-teams-sublist { 
            background: #0e0e11; 
            border: 1px solid #1f1f24; 
            border-top: none; 
            border-radius: 0 0 8px 8px; 
            padding: 10px; 
            display: none; 
            max-height: 250px; 
            overflow-y: auto; 
        }
        .my-teams-sublist.open { display: block; }
        .team-mini-row { display: flex; align-items: center; gap: 10px; padding: 8px; border-bottom: 1px solid #1a1a1e; font-size: 0.85rem; color: #bcbcc4; }
        .team-mini-row:last-child { border-bottom: none; }
        .team-mini-avatar { width: 26px; height: 26px; border-radius: 4px; object-fit: cover; background: #232329; }
        .team-mini-info { display: flex; flex-direction: column; overflow: hidden; }
        .team-mini-name { font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .team-mini-game { font-size: 0.75rem; color: #7e7e86; }

        /* ==========================================================================
           UPDATED: INVITE PLAYERS NEW CARD DESIGN (MATCHING YOUR PHOTO)
           ========================================================================== */
        .card-invite-custom {
            background-color: #121214 !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 40px !important;
        }

        .main-title-custom {
            display: flex;
            align-items: center;
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 35px;
            gap: 12px;
        }

        .main-title-custom svg {
            fill: #e07a2c;
            width: 32px;
            height: 32px;
        }

        .section-group-custom {
            margin-bottom: 30px;
        }

        .section-title-custom {
            color: #e07a2c;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title-custom svg {
            fill: #e07a2c;
            width: 18px;
            height: 18px;
        }

        .section-desc-custom {
            color: #8a8b8f;
            font-size: 14px;
            margin-top: -8px;
            margin-bottom: 16px;
        }

        .input-row-custom {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }

        .search-wrapper-custom {
            position: relative;
            flex-grow: 1;
        }

        .search-input-custom {
            width: 100%;
            background-color: #18181c;
            border: 1px solid #1f1f23;
            border-radius: 8px;
            padding: 16px 20px;
            color: #ffffff;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input-custom:focus {
            border-color: #e07a2c;
        }

        .search-input-custom::placeholder {
            color: #4a4b50;
        }

        .dot-indicator-custom {
            position: absolute;
            left: 140px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background-color: #ff4d4d;
            border-radius: 50%;
        }

        .btn-action-custom {
            background-color: #8c4a19;
            border: none;
            border-radius: 8px;
            width: 52px;
            height: 52px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-action-custom:hover {
            background-color: #a6581e;
        }

        .btn-action-custom svg {
            fill: #121214;
            width: 22px;
            height: 22px;
        }

        .info-box-custom {
            background-color: #151517;
            border: 1px solid #1c1c1f;
            border-radius: 8px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #5c5d63;
            font-size: 15px;
            margin-top: 14px;
        }

        .info-box-custom svg {
            fill: #5c5d63;
            width: 18px;
            height: 18px;
        }

        .footer-actions-custom {
            display: flex;
            gap: 20px;
            margin-top: 40px;
        }

        .btn-footer-custom {
            flex: 1;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s;
        }

        .btn-footer-custom:hover {
            opacity: 0.9;
        }

        .btn-skip-custom {
            background-color: #3e4554;
            color: #dae0ea;
            border: none;
        }

        .btn-submit-custom {
            background-color: #8c4a19;
            color: #121214;
            border: none;
        }

        .btn-submit-custom svg {
            fill: #121214;
            width: 18px;
            height: 18px;
        }
        /* ========================================================================== */

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
        .ac{
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
                     <a href="index.php">Home</a>
                     <div class="dropdown">
                         <a href="#">Play <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.75rem;"></i></a>
                         <div class="dropdown-content">
                             <a href="#">Leaderboard Matches</a>
                             <a href="#">Tournament</a>
                         </div>
                     </div>
                     <a href="#">Shop</a>
                     <a href="#" class="active">Create Team</a>
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
                        <div class="avatar-pill" id="avatarBtn" style="cursor: pointer;" title="User Menu" aria-haspopup="true" aria-expanded="false">
                        </div>
                        
                        <div class="user-menu-dropdown" id="userDropdown" role="menu" aria-labelledby="avatarBtn">
                            <div class="dropdown-header-user">
                                <i class="fa-solid fa-circle-user"></i>
                                <span class="dropdown-username">User</span>
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
</div>

<div class="dashboard-container">
    
    <div class="left-panel-wrapper">
        <div class="widget-panel">
            <div class="user-profile-summary">
                <div class="summary-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="summary-name">
                    Gamer_User
                    <span class="geo-tag">IND</span>
                </div>
            </div>

            <div class="metrics-list">
                <div class="metric-row"><span class="metric-label">Joined</span><span class="metric-val text-success">5 mins ago</span></div>
                <div class="metric-row"><span class="metric-label">Credits</span><span class="metric-val credits">0</span></div>
                <div class="metric-row"><span class="metric-label">Rank</span><span class="metric-val text-warning">Novice</span></div>
                <div class="metric-row"><span class="metric-label">Current Earnings</span><span class="metric-val highlight">$0.00</span></div>
                <div class="metric-row"><span class="metric-label">Matches Won</span><span class="metric-val">0</span></div>
                <div class="metric-row"><span class="metric-label">Global Rank</span><span class="metric-val text-warning">#3,476</span></div>
            </div>
        </div>

        <div class="action-list">
            <div id="myTeamsToggleBtn" class="btn-action-panel">
                <span>My Teams (1)</span>
                <span class="btn-orange-add"><i class="fa-solid fa-chevron-down" id="chevronIcon"></i></span>
            </div>
            
            <div class="my-teams-sublist" id="myTeamsSublist">
                <div class="team-mini-row">
                    <img src="img/default_team.jpg" class="team-mini-avatar" alt="Team Avatar">
                    <div class="team-mini-info">
                        <span class="team-mini-name">Alpha Squad</span>
                        <span class="team-mini-game">COD: BLACK OPS 6</span>
                    </div>
                </div>
            </div>

            <a href="#" class="btn-action-panel"><span>Joined Tournaments (0)</span></a>
            <a href="#" class="btn-action-panel"><span>Friends List (2)</span><i class="fa-solid fa-user-plus text-secondary"></i></a>
        </div>
    </div>

    <div class="card card-invite-custom">
        <div class="main-title-custom">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 1.34 5 3s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
            Invite Players
        </div>

        <div class="section-group-custom">
            <div class="section-title-custom">Invite Players</div>
            
            <div class="input-row-custom">
                <div class="search-wrapper-custom">
                    <input type="text" class="search-input-custom" placeholder="Search Players...">
                </div>
                <button class="btn-action-custom" type="button">
                    <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </button>
            </div>

            <div class="input-row-custom">
                <div class="search-wrapper-custom">
                    <input type="text" class="search-input-custom" placeholder="Search Players...">
                </div>
                <button class="btn-action-custom" type="button">
                    <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </button>
            </div>

            <div class="input-row-custom">
                <div class="search-wrapper-custom">
                    <input type="text" class="search-input-custom" placeholder="Search Players...">
                </div>
                <button class="btn-action-custom" type="button">
                    <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </button>
            </div>
        </div>

        <div class="section-group-custom">
            <div class="section-title-custom">
                <svg viewBox="0 0 24 24">
                    <path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/>
                </svg>
                Substitute Player
            </div>
            <div class="section-desc-custom">Invite a substitute player to your team in case a member is unavailable.</div>
            
            <div class="input-row-custom">
                <div class="search-wrapper-custom">
                    <input type="text" class="search-input-custom" placeholder="Search Players...">
                </div>
                <button class="btn-action-custom" type="button">
                    <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </button>
            </div>

            <div class="info-box-custom">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                No substitute player selected yet
            </div>
        </div>

        <div class="footer-actions-custom">
            <a href="createteam.php" style="text-decoration: none;" class="ac"><button class="btn-footer-custom btn-skip-custom" type="button">Skip</button></a>
            <button class="btn-footer-custom btn-submit-custom" type="button">
                <svg viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
                Send Requests
            </button>
        </div>
    </div>
    </div>

<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <img src="img/prg.jpg" alt="PRG Logo">
            <p>Competitive gaming platform for players of all skill levels.</p>
            <div class="social-row">
                <i class="fab fa-discord"></i><i class="fab fa-instagram"></i><i class="fab fa-twitter"></i><i class="fab fa-youtube"></i>
            </div>
        </div>
        <div class="footer-links-col">
            <h3>Play</h3>
            <a href="#">Tournaments</a><a href="#">Leaderboard</a><a href="#">Teams</a>
        </div>
        <div class="footer-links-col">
            <h3>Support</h3>
            <a href="#">FAQ</a><a href="#">Support Ticket</a>
        </div>
        <div class="footer-links-col">
            <h3>Legal</h3>
            <a href="#">Terms & Conditions</a><a href="#">Privacy Policy</a>
        </div>
    </div>
    <div class="footer-copyright">
        &copy; 2026 Play Rivals Gaming LLC. All rights reserved.
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion sidebar toggles
    const myTeamsToggleBtn = document.getElementById('myTeamsToggleBtn');
    const myTeamsSublist = document.getElementById('myTeamsSublist');
    const chevronIcon = document.getElementById('chevronIcon');

    if(myTeamsToggleBtn && myTeamsSublist) {
        myTeamsToggleBtn.addEventListener('click', function() {
            myTeamsSublist.classList.toggle('open');
            chevronIcon.className = myTeamsSublist.classList.contains('open') ? "fa-solid fa-chevron-up" : "fa-solid fa-chevron-down";
        });
    }

    // Panels logic
    const avatarBtn = document.getElementById('avatarBtn');
    const userDropdown = document.getElementById('userDropdown');
    const chatNotificationBtn = document.getElementById('chatNotificationBtn');
    const chatNotificationPanel = document.getElementById('chatNotificationPanel');
    const generalNotificationBtn = document.getElementById('generalNotificationBtn');
    const generalNotificationPanel = document.getElementById('generalNotificationPanel');

    function closeAllPanels() {
        if(userDropdown) userDropdown.classList.remove('show');
        if(chatNotificationPanel) chatNotificationPanel.classList.remove('show');
        if(generalNotificationPanel) generalNotificationPanel.classList.remove('show');
    }

    if (avatarBtn && userDropdown) {
        avatarBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            let isShown = userDropdown.classList.contains('show');
            closeAllPanels();
            if(!isShown) userDropdown.classList.add('show');
        });
    }

    if (chatNotificationBtn && chatNotificationPanel) {
        chatNotificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            let isShown = chatNotificationPanel.classList.contains('show');
            closeAllPanels();
            if(!isShown) chatNotificationPanel.classList.add('show');
        });
    }

    if (generalNotificationBtn && generalNotificationPanel) {
        generalNotificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            let isShown = generalNotificationPanel.classList.contains('show');
            closeAllPanels();
            if(!isShown) generalNotificationPanel.classList.add('show');
        });
    }

    document.addEventListener('click', function() {
        closeAllPanels();
    });
});
</script>
</body>
</html>