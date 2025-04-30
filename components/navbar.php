<?php
function renderNavbar($label, $icon, $showPublishButton) {
    // Get the user's profile picture from the session or database
    require_once __DIR__ . '/../conn/db.php';
    global $pdo; // Make $pdo available in this function
    
    // Check if $pdo is null and handle it gracefully
    if (!isset($pdo) || $pdo === null) {
        // If $pdo is not available, use default image and continue
        $profilePicture = 'assets/user.png';
    } else {
        $user_id = $_SESSION['user_id'];
        $profilePicture = 'assets/user.png'; // Default image
        
        try {
            $stmt = $pdo->prepare("SELECT profile_picture_url FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && !empty($user['profile_picture_url'])) {
                $profilePicture = $user['profile_picture_url'];
            }
        } catch (PDOException $e) {
            // If there's an error, use the default image
        }
    }
    
    $publishButton = '';
    if ($showPublishButton) {
        $publishButton = '
            <header>
                <div class="left-nav"><a href="dashboard.php">Blogz</a></div>
                <div class="right-nav">
                    <ul>
                        <button type="submit" form="createPostForm" onclick="navigateToPage(\'dashboard.php\')" class="create-post-btn"><i class="' . htmlspecialchars($icon). '"></i>' . htmlspecialchars($label) . '</button>
                        <li class="dropdown">
                            <img class="drop-img" src="' . htmlspecialchars($profilePicture) . '" alt="Profile">
                            <div class="dropdown-content">
                                <a href="profile-page.php"><i class="fa-regular fa-user"></i>Profile</a>
                                <a href="my-blog.php"><i class="fa-solid fa-book"></i>My Blogs</a>
                                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>
        ';
    } else {
        $publishButton = '
            <header>
                <div class="left-nav"><a href="dashboard.php">Blogz</a></div>
                <div class="right-nav">
                    <ul>
                        <button onclick="navigateToPage(\'create-post.php\')" class="create-post-btn"><i class="' . htmlspecialchars($icon). '"></i>' . htmlspecialchars($label) . '</button>
                        <li class="dropdown">
                            <img class="drop-img" src="' . htmlspecialchars($profilePicture) . '" alt="Profile">
                            <div class="dropdown-content">
                                <a href="profile-page.php"><i class="fa-regular fa-user"></i>Profile</a>
                                <a href="my-blog.php"><i class="fa-solid fa-book"></i>My Blogs</a>
                                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>
        ';
    }

    return $publishButton . '
       <style>
            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
                color: #fff;
            }

            .left-nav a {
                color: rgb(76, 147, 175);
                text-decoration: none;
                font-family: "Sigmar", sans-serif;
                font-weight: 400;
                font-style: normal;
                font-size: 30px;
            }

            .right-nav ul {
                display: flex;
                align-items: center;
                list-style: none;
                padding: 0px;
                margin: 0px;
            }

            .right-nav ul li {
                margin-left: 10px;
            }

            .create-post-btn i {
                margin-right: 2px;
            }

            .create-post-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 12px 24px;
                background-color: rgb(76, 147, 175);
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 400;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                gap: 5px;
            }

            .create-post-btn:hover {
                background-color: rgb(64, 121, 143);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .create-post-btn i {
                font-size: 16px;
            }

            .drop-img {
                width: 40px; 
                height: 40px;
                border-radius: 50%;
                margin-left: 10px;
                transition: filter 0.3s;
                object-fit: cover; 
            }

            .dropdown:hover .drop-img {
                cursor: pointer;
                filter: brightness(80%);
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                background-color: #fff;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                z-index: 1;
            }

            .dropdown-content a {
                color: #333 !important;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                font-size: 14px;
            }

            .dropdown-content a i {
                margin-right: 8px;
                color: #666;
            }

            .dropdown-content a:hover {
                background-color: #f1f1f1;
            }

            .dropdown-content.show {
                display: block;
            }

            .dropdown:hover .drop-img {
                cursor: pointer;
            }
       </style>

       <script>
            function navigateToPage(where) {
                window.location.href = where;
            }
       </script>
    ';
}
?>
