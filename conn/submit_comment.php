<?php
session_start();
if (!isset($_SESSION['user_id'])) {
     header('Content-Type: application/json');
     echo json_encode(['success' => false, 'message' => 'You must be logged in to comment']);
     exit();
}

include 'db.php';
include 'comments.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $blog_id = isset($_POST['blog_id']) ? (int)$_POST['blog_id'] : 0;
     $content = isset($_POST['content']) ? trim($_POST['content']) : '';
     $user_id = $_SESSION['user_id'];

     // Validate
     if (!$blog_id || empty($content)) {
          header('Content-Type: application/json');
          echo json_encode(['success' => false, 'message' => 'Blog ID and comment content are required']);
          exit();
     }

     $success = addComment($blog_id, $user_id, $content);

     if ($success) {
          // If it's an AJAX request, return success
          if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               header('Content-Type: application/json');
               echo json_encode(['success' => true]);
               exit();
          } else {
               header("Location: ../blog-detail.php?id=$blog_id");
               exit();
          }
     } else {
          header('Content-Type: application/json');
          echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
          exit();
     }
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
     $comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;
     $blog_id = isset($_GET['blog_id']) ? (int)$_GET['blog_id'] : 0;
     $user_id = $_SESSION['user_id'];

     if (!$comment_id || !$blog_id) {
          header("Location: ../blog-detail.php?id=$blog_id&error=Invalid comment ID");
          exit();
     }

     $success = deleteComment($comment_id, $user_id);

     header("Location: ../blog-detail.php?id=$blog_id");
     exit();
}