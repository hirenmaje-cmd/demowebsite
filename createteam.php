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

        /* Shared Side Panels Styles */
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
        
        .color-tournament { color: #f97316; }
        .color-royale { color: #f59e0b; }
        .color-ladders { color: #f59e0b; }
        .color-scrim { color: #ea580c; }
        .color-coaching { color: #f97316; }
        .color-gray-icon { color: #a1a1a8; }
        
        /* Dashboard Layout */
        .dashboard-container { display: grid; grid-template-columns: 280px 1fr; gap: 30px; padding: 25px 40px; max-width: 1800px; margin: 0 auto; }
        .widget-panel { background: #141417; border: 1px solid #1f1f24; border-radius: 10px; padding: 20px; }
        
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

        .action-list { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
        .btn-action-panel { background: #1a1a1f; border: 1px solid #26262d; color: #fff; padding: 12px; border-radius: 8px; font-weight: 600; text-align: left; display: flex; justify-content: space-between; align-items: center; text-decoration: none; font-size: 0.9rem; width: 100%; cursor: pointer;}
        .btn-action-panel:hover { border-color: #ff7a00; color: #ff7a00; }
        .btn-orange-add { background: #ff7a00; color: white; width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; }

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

        /* Form Styles */
        .main-content-wrapper { background: #141417; border: 1px solid #1f1f24; border-radius: 12px; padding: 30px; }
        .form-main-title { font-size: 1.6rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 12px; margin-bottom: 30px; border-bottom: 1px solid #1f1f24; padding-bottom: 15px; }
        .form-main-title i { color: #ff7a00; }
        
        .form-label-custom { color: #ff7a00; font-weight: 600; font-size: 0.95rem; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: block; }
        .form-input-custom { width: 100%; background: #0c0c0e; border: 1px solid #232329; border-radius: 8px; padding: 12px 16px; color: #ffffff; font-size: 0.95rem; transition: border-color 0.2s; margin-bottom: 25px; }
        .form-input-custom:focus { border-color: #ff7a00; outline: none; }
        
        .gamer-tag-area { display: none; background: #18181c; padding: 15px; border-radius: 8px; border: 1px dashed #2d2d35; margin-bottom: 25px; }
        .btn-gamer-tag { background: #ff7a00; color: #fff; border: none; padding: 10px 20px; font-weight: 600; border-radius: 6px; font-size: 0.9rem; transition: background 0.2s; text-decoration: none; display: inline-block; margin-bottom: 8px; cursor: pointer; }
        .btn-gamer-tag:hover { background: #e06c00; color: #fff; }
        .input-hint-text { color: #7e7e86; font-size: 0.85rem; margin-bottom: 25px; display: block; }
        
        .file-upload-wrapper { position: relative; margin-bottom: 12px; }
        .btn-file-dummy { background: #0c0c0e; border: 1px solid #2d2d35; border-radius: 6px; padding: 10px 18px; color: #bcbcc4; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: border-color 0.2s; }
        .btn-file-dummy:hover { border-color: #ff7a00; }
        .file-note { color: #7e7e86; font-size: 0.8rem; margin-bottom: 35px; }
        
        .btn-submit-team { background: linear-gradient(90deg, #ff7a00 0%, #e06c00 100%); color: #fff; border: none; width: 100%; padding: 14px; font-weight: 700; font-size: 1rem; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase; cursor: pointer; transition: opacity 0.2s; }
        .btn-submit-team:hover { opacity: 0.9; }

        /* Footer Rules */
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
                        <div class="avatar-pill" id="avatarBtn" title="User Menu" aria-haspopup="true" aria-expanded="false">
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
                <span>My Teams (0)</span>
                <span class="btn-orange-add"><i class="fa-solid fa-chevron-down" id="chevronIcon"></i></span>
            </div>
            
            <div class="my-teams-sublist" id="myTeamsSublist">
                <div class="team-mini-row">
                
                   
                </div>
            </div>

            <a href="#" class="btn-action-panel"><span>Joined Tournaments (0)</span></a>
            <a href="#" class="btn-action-panel"><span>Friends List (2)</span><i class="fa-solid fa-user-plus text-secondary"></i></a>
        </div>
    </div>

    <div class="main-content-wrapper">
        <h2 class="form-main-title">
            <i class="fa-solid fa-users-gear"></i> Create Team
        </h2>
        
        <form action="createteam67.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12">
                    <label class="form-label-custom">Team Name</label>
                    <input type="text" name="team_name" class="form-input-custom" placeholder="Enter Team Name" required>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label-custom">Team Size</label>
                    <select name="team_size" class="form-input-custom">
                        <option value="single">Single</option>
                        <option value="duo">Duo</option>
                        <option value="squad" selected>Squad</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label-custom">Game</label>
                    <select name="game_select" id="gameSelect" class="form-input-custom" required>
                        <option value="">Select the Game</option>
                        <option value="free_fire" data-tag="Free Fire UID">Free Fire Max</option>
                        <option value="cod_warzone" data-tag="Activision ID">Call of Duty: Warzone</option>
                        <option value="ea_fc_25" data-tag="EA ID">EA Sports FC 25</option>
                        <option value="cod_bo6" data-tag="Activision ID" selected>Call of Duty: Black Ops 6</option>
                        <option value="fortnite" data-tag="Epic Games ID">Fortnite</option>
                        <option value="rocket_league" data-tag="Epic Games ID">Rocket League</option>
                        <option value="mlbb" data-tag="MLBB Game ID">Mobile Legends: Bang Bang</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <button type="button" class="btn-gamer-tag" id="addGamerTagBtn">Add Gamer Tag</button>
                    <span class="input-hint-text" id="hintText">Click "Add Gamer Tag" to add your Activision ID for this team</span>
                    
                    <div class="gamer-tag-area" id="gamerTagArea">
                        <label class="form-label-custom" id="dynamicLabel">Activision ID</label>
                        <input type="text" name="gamer_tag_id" class="form-input-custom mb-0" placeholder="Enter ID here...">
                    </div>
                </div>
                
                <div class="col-12">
                    <label class="form-label-custom">Team Avatar</label>
                    <div class="file-upload-wrapper">
                        <label for="team_avatar" class="btn-file-dummy">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Choose Team Avatar
                        </label>
                        <input type="file" id="team_avatar" name="team_avatar" accept="image/webp, image/jpeg, image/png" style="display: none;">
                        <span id="file-chosen-name" class="ms-2 text-secondary" style="font-size:0.85rem;">No file chosen</span>
                    </div>
                    <p class="file-note">Note: Please upload WebP, PNG, or JPG images, max size 250KB</p>
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn-submit-team">
                        <i class="fa-solid fa-users"></i> Create Team
                    </button>
                </div>
            </div>
        </form>
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
    
    // File upload handler
    const fileInput = document.getElementById('team_avatar');
    const fileChosenName = document.getElementById('file-chosen-name');
    if(fileInput) {
        fileInput.addEventListener('change', function() {
            fileChosenName.textContent = this.files.length > 0 ? this.files[0].name : "No file chosen";
        });
    }

    // Sidebar accordion toggles
    const myTeamsToggleBtn = document.getElementById('myTeamsToggleBtn');
    const myTeamsSublist = document.getElementById('myTeamsSublist');
    const chevronIcon = document.getElementById('chevronIcon');

    if(myTeamsToggleBtn && myTeamsSublist) {
        myTeamsToggleBtn.addEventListener('click', function() {
            myTeamsSublist.classList.toggle('open');
            chevronIcon.className = myTeamsSublist.classList.contains('open') ? "fa-solid fa-chevron-up" : "fa-solid fa-chevron-down";
        });
    }

    // Dynamic Game Selection
    const gameSelect = document.getElementById('gameSelect');
    const addGamerTagBtn = document.getElementById('addGamerTagBtn');
    const gamerTagArea = document.getElementById('gamerTagArea');
    const dynamicLabel = document.getElementById('dynamicLabel');
    const hintText = document.getElementById('hintText');

    function updateGamerTagLabel() {
        const selectedOption = gameSelect.options[gameSelect.selectedIndex];
        const tagName = selectedOption ? selectedOption.getAttribute('data-tag') : "Gamer Tag";
        
        if(tagName) {
            dynamicLabel.textContent = tagName;
            hintText.textContent = `Click "Add Gamer Tag" to add your ${tagName} for this team`;
            gamerTagArea.querySelector('input').placeholder = `Enter your ${tagName}...`;
        }
    }

    if(gameSelect) {
        gameSelect.addEventListener('change', updateGamerTagLabel);
        updateGamerTagLabel();
    }

    if(addGamerTagBtn && gamerTagArea) {
        addGamerTagBtn.addEventListener('click', function() {
            if(gameSelect.value === "") {
                alert("Please select a game first!");
                return;
            }
            gamerTagArea.style.display = (gamerTagArea.style.display === 'block') ? 'none' : 'block';
        });
    }

    // Slide Panels and Dropdowns
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