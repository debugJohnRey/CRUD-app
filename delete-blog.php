<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conn/db.php';

// Get the blog ID from the URL
$blog_id = isset($_GET['id']) ? $_GET['id'] : null;
$user_id = $_SESSION['user_id'];

if (!$blog_id) {
    header("Location: my-blogs-page.php");
    exit();
}

try {
    // First, check if the blog belongs to the current user and get the thumbnail URL
    $stmt = $pdo->prepare("SELECT user_id, thumbnail_url FROM blogs WHERE blog_id = ?");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$blog || $blog['user_id'] != $user_id) {
        // Either blog doesn't exist or doesn't belong to current user
        header("Location: my-blogs-page.php");
        exit();
    }
    
    // Store the thumbnail URL for deletion after the blog is removed
    $thumbnail_url = $blog['thumbnail_url'] ?? '';
    
    // If we get here, the blog exists and belongs to the current user, so delete it
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE blog_id = ? AND user_id = ?");
    $result = $stmt->execute([$blog_id, $user_id]);
    
    // If blog was successfully deleted, delete the thumbnail file if it exists
    // and is not the default thumbnail
    if ($result && !empty($thumbnail_url) && $thumbnail_url !== 'assets/thumbnail.png') {
        $full_thumbnail_path = $_SERVER['DOCUMENT_ROOT'] . '/CRUD-app/' . $thumbnail_url;
        if (file_exists($full_thumbnail_path)) {
            unlink($full_thumbnail_path);
        }
    }
    
    // Redirect back to my blogs page
    header("Location: my-blogs-page.php");
    exit();
    
} catch (PDOException $e) {
    die("Error deleting blog: " . $e->getMessage());
}
?>