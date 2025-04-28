<?php
// Start session if not already started
session_start();

// Include database connection
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error response
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Username and email are required']);
        exit();
    }
    
    // Initialize profile picture path variable
    $profile_picture_path = null;
    
    // Handle profile picture upload if present
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profile_pictures/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $filename = $user_id . '_' . time() . '.' . $file_extension;
        $target_file = $upload_dir . $filename;
        
        // Check file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed']);
            exit();
        }
        
        // Check file size (max 5MB)
        if ($_FILES['profile_picture']['size'] > 5000000) {
            echo json_encode(['success' => false, 'message' => 'File is too large (max 5MB)']);
            exit();
        }
        
        // Upload file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $profile_picture_path = 'uploads/profile_pictures/' . $filename;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload profile picture']);
            exit();
        }
    }
    
    // Update user data in database
    try {
        // If profile picture was uploaded, include it in the update
        if ($profile_picture_path) {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, email = ?, profile_picture_url = ? WHERE user_id = ?");
            $result = $stmt->execute([$username, $email, $profile_picture_path, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, email = ? WHERE user_id = ?");
            $result = $stmt->execute([$username, $email, $user_id]);
        }
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Password is required']);
        exit();
    }
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Update password in database
    try {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $result = $stmt->execute([$hashed_password, $user_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update password']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    try {
        // Delete user from database
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $result = $stmt->execute([$user_id]);
        
        if ($result) {
            // Destroy session
            session_unset();
            session_destroy();
            
            echo json_encode(['success' => true, 'message' => 'Account deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete account']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}

// If no valid action was specified
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>