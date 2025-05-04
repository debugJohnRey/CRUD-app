<?php
    session_start();
    
    include 'conn/db.php';
    
    $username = "";
    $password = "";
    $date_joined = "";
    $email = "";
    $profile_picture = "assets/user.png";
    
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        // Query to fetch user data
        try {
            $stmt = $pdo->prepare("SELECT first_name, password, created_at, email, profile_picture_url FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $username = $row['first_name'];
                $date_joined = $row['created_at'];
                $email = $row['email'];
                
                // Use user's profile picture if available
                if (!empty($row['profile_picture_url'])) {
                    $profile_picture = $row['profile_picture_url'];
                }
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
    <div class="profile-picture" id="profilePictureContainer">
      <img class="profile-picture-img" src="<?php echo htmlspecialchars($profile_picture); ?>" alt="profile-picture" id="profileImage">
      <div class="profile-picture-overlay" id="profilePictureOverlay">
        <label for="profilePictureInput">
          <i class="fas fa-camera"></i>
        </label>
        <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
      </div>
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
        <button class="delete-account-button" id="deleteAccountBtn">Delete Account</button>

        <div id="myModal" class="modal">
          <p>Enter your new password.</p>
          <input type="password" class="change-password-input" maxlength="12" autocomplete="new-password">
          <div style="margin-top: 10px;">
            <button onclick="savePassword()" class="save-password-btn">Save</button>
            <button onclick="closeModal()" class="close-btn">Close</button>
          </div>
        </div>
        
        <div id="deleteConfirmModal" class="modal">
          <p>Are you sure you want to delete your account? This action cannot be undone.</p>
          <div style="margin-top: 10px;">
            <button onclick="confirmDeleteAccount()" class="delete-confirm-btn">Delete </button>
            <button onclick="closeDeleteConfirmModal()" class="close-btn">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const editProfileBtn = document.getElementById('editProfileBtn');
      const deleteAccountBtn = document.getElementById('deleteAccountBtn');
      const inputFields = document.querySelectorAll('.profile-info-details');
      const profilePictureOverlay = document.getElementById('profilePictureOverlay');
      const profilePictureInput = document.getElementById('profilePictureInput');
      const profileImage = document.getElementById('profileImage');
      let isEditing = false;
      let selectedFile = null;
      
      // Add event listener for delete account button
      deleteAccountBtn.addEventListener('click', function() {
        openDeleteConfirmModal();
      });
      
      editProfileBtn.addEventListener('click', function() {
        isEditing = !isEditing;
        
        if (isEditing) {
          // Enable editing
          inputFields.forEach(input => {
            input.removeAttribute('readonly');
          });
          editProfileBtn.textContent = 'Save Profile';
          
          // Show profile picture overlay when in edit mode
          profilePictureOverlay.classList.add('active');
        } else {
          // Get updated values
          const username = document.querySelector('.profile-info-details[value^="<?php echo htmlspecialchars($username); ?>"]').value;
          const email = document.querySelector('.profile-info-details[value^="<?php echo htmlspecialchars($email); ?>"]').value;
          
          // Create FormData object for file upload
          const formData = new FormData();
          formData.append('action', 'update_profile');
          formData.append('username', username);
          formData.append('email', email);
          
          // Add profile picture if one was selected
          if (selectedFile) {
            formData.append('profile_picture', selectedFile);
          }
          
          // Show loading state or disable button while saving
          editProfileBtn.textContent = 'Saving...';
          editProfileBtn.disabled = true;
          
          fetch('conn/update-profile.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Profile updated successfully!');
              // Refresh the page to show updated data
              location.reload();
            } else {
              // If there's an error, keep fields editable
              alert('Error: ' + data.message);
              editProfileBtn.textContent = 'Save Profile';
              editProfileBtn.disabled = false;
              isEditing = true; // Keep in edit mode
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating your profile.');
            // If there's an error, keep fields editable
            editProfileBtn.textContent = 'Save Profile';
            editProfileBtn.disabled = false;
            isEditing = true; // Keep in edit mode
          });
          
          // Only disable editing if the save is successful
          
          // Hide profile picture overlay
          profilePictureOverlay.classList.remove('active');
        }
      });
      
      // Handle profile picture selection
      profilePictureInput.addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
          selectedFile = event.target.files[0];
          
          // Display the selected image preview
          const reader = new FileReader();
          reader.onload = function(e) {
            profileImage.src = e.target.result;
          };
          reader.readAsDataURL(selectedFile);
        }
      });
    });

    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
      const passwordInput = document.querySelector('.change-password-input');
      if (passwordInput) {
        passwordInput.value = '';
      }
      document.getElementById("myModal").style.display = "none";
    }
    
    function openDeleteConfirmModal() {
      document.getElementById("deleteConfirmModal").style.display = "block";
    }
    
    function closeDeleteConfirmModal() {
      document.getElementById("deleteConfirmModal").style.display = "none";
    }
    
    function confirmDeleteAccount() {
      // Send delete request to server
      const formData = new FormData();
      formData.append('action', 'delete_account');
      
      fetch('conn/update-profile.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Your account has been deleted successfully.');
          // Redirect to login page
          window.location.href = 'index.php';
        } else {
          alert('Error: ' + data.message);
          closeDeleteConfirmModal();
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting your account.');
        closeDeleteConfirmModal();
      });
    }
    
    // Add function to save password
    function savePassword() {
      const passwordInput = document.querySelector('.change-password-input');
      const newPassword = passwordInput.value.trim();
      
      if (!newPassword) {
        alert('Please enter a new password');
        return;
      }
      
      // Send password to server
      const formData = new FormData();
      formData.append('action', 'update_password');
      formData.append('password', newPassword);
      
      fetch('conn/update-profile.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Password updated successfully!');
          closeModal();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating your password.');
      });
    }
  </script>
</body>
</html>
