<?php
    // Start session if not already started
    session_start();
    
    // Include database connection
    include 'conn/db.php';
    
    // Initialize variables
    $username = "";
    $password = "";
    $date_joined = "";
    $email = "";
    
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        // Query to fetch user data
        try {
            $stmt = $pdo->prepare("SELECT first_name, password, created_at, email FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $username = $row['first_name'];
                $date_joined = $row['created_at'];
                $email = $row['email'];
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        // Redirect to login page if not logged in
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, nitial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sigmar&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>My Profile</title>
    <link rel="stylesheet" href="css/profile-page.css">
    <link rel="icon" href="assets/logo.png" type="image/png">
</head>
<body>
  <header>
    <div class="left-nav"><a href="dashboard.php">Blogz</a></div>
  </header>
  <div class="profile-container">
    <div class="profile-picture">
      <img class="profile-picture-img" src="assets/user.png" alt="profile-picture">
    </div>
      
    <div class="profile-info">
      <p>Username: </p>
      <input type="text" class="profile-info-details" value="<?php echo htmlspecialchars($username); ?>" readonly>
      <p>Email: </p>
      <input type="text" class="profile-info-details" value="<?php echo htmlspecialchars($email); ?>" readonly>
      <p>Password: </p>
      <button onclick="openModal()">Change Password</button>
      <p>Date Joined: </p>
      <p><?php echo htmlspecialchars($date_joined); ?></p>

      <div class="profile-buttons-container">
        <button class="edit-profile-button" id="editProfileBtn" name="update">Edit Profile</button>
        <button class="delete-account-button">Delete Account</button>

        <div id="myModal" style="display:none; 
                        position:fixed; 
                        top: 50%;                   /* Center vertically */
                        left: 50%;                  /* Center horizontally */
                        transform: translate(-50%, -50%);  /* Adjust for exact center */
                        width: 50%;                 /* 50% of viewport width */
                        max-width: 600px;           /* Maximum width */
                        height: auto;               /* Height adjusts to content */
                        max-height: 80vh;           /* Maximum height */
                        background:white; 
                        padding:20px; 
                        border:1px solid #ccc; 
                        border-radius: 8px;         /* Rounded corners */
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Shadow effect */
                        z-index:1000;
                        overflow:auto;">
          <p>This is a custom popup!</p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium, eligendi esse architecto ipsa natus adipisci ea temporibus dolore, vel accusantium voluptatibus obcaecati ipsam delectus voluptate et dicta nesciunt cupiditate quidem?
          </p>
          <button onclick="closeModal()">Save Password</button>
          <button onclick="closeModal()">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const editProfileBtn = document.getElementById('editProfileBtn');
      const inputFields = document.querySelectorAll('.profile-info-details');
      let isEditing = false;
      
      editProfileBtn.addEventListener('click', function() {
        isEditing = !isEditing;
        
        if (isEditing) {
          // Enable editing
          inputFields.forEach(input => {
            input.removeAttribute('readonly');
          });
          editProfileBtn.textContent = 'Save Profile';
        } else {
          // Save changes and disable editing
          inputFields.forEach(input => {
            input.setAttribute('readonly', true);
          });
          editProfileBtn.textContent = 'Edit Profile';
          
          // Here you would typically add code to save the changes to the database
          // For example: submitProfileChanges();
        }
      });
    });

    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }
  </script>
</body>
</html>
