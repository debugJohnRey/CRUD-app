<?php
function fetchComments($blog_id)
{
     $host = 'localhost';
     $db = 'blogz';
     $user = 'root';
     $pass = '';

     try {
          $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $pdo->prepare("
            SELECT comments.comment_id, comments.content, comments.created_at,
                   users.user_id, users.first_name, users.profile_picture_url
            FROM comments
            JOIN users ON comments.user_id = users.user_id
            WHERE comments.blog_id = ?
            ORDER BY comments.created_at ASC
        ");

          $stmt->execute([$blog_id]);
          $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

          return $comments;
     } catch (PDOException $e) {
          die("Could not fetch comments: " . $e->getMessage());
     }
}

// Function to add a new comment
function addComment($blog_id, $user_id, $content)
{
     $host = 'localhost';
     $db = 'blogz';
     $user = 'root';
     $pass = '';

     try {
          $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $pdo->prepare("
            INSERT INTO comments (blog_id, user_id, content)
            VALUES (?, ?, ?)
        ");

          $success = $stmt->execute([$blog_id, $user_id, $content]);
          return $success;
     } catch (PDOException $e) {
          die("Could not add comment: " . $e->getMessage());
     }
}

// Function to delete a comment
function deleteComment($comment_id, $user_id)
{
     $host = 'localhost';
     $db = 'blogz';
     $user = 'root';
     $pass = '';

     try {
          $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Only allow deletion if the user owns the comment
          $stmt = $pdo->prepare("
            DELETE FROM comments
            WHERE comment_id = ? AND user_id = ?
        ");

          $success = $stmt->execute([$comment_id, $user_id]);
          return $success;
     } catch (PDOException $e) {
          die("Could not delete comment: " . $e->getMessage());
     }
}