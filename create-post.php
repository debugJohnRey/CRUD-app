<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'conn/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $thumbnail_url = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['thumbnail']['name']);
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadFile)) {
            $thumbnail_url = $uploadFile;
        }
    } else {
        // Use default thumbnail only if no image was uploaded
        $thumbnail_url = 'assets/thumbnail.png';
    }

    try {
        $sql = "INSERT INTO blogs (user_id, title, content, thumbnail_url) VALUES (:user_id, :title, :content, :thumbnail_url)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':content' => $content,
            ':thumbnail_url' => $thumbnail_url
        ]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sigmar&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="icon" href="assets/logo.png" type="image/png">
  <link rel="stylesheet" href="css/styles.css">
  <title>Create Post</title>
</head>
<body>
  <?php 
    include 'components/navbar.php';
    include 'components/post.php';

    echo renderNavbar( 
      "Publish", 
      "fa-solid fa-circle-check",
      true
    );

    echo renderCreatePost();
  ?>
  
  <script src="js/scripts.js"></script>
  <script>
    document.getElementById('createPostForm').addEventListener('submit', function(e) {
      const title = document.getElementById('autoResizeTextareaTitle').value.trim();
      const content = document.getElementById('autoResizeTextareaContent').value.trim();
      
      if (!title || !content) {
        e.preventDefault();
        alert('You can\'t publish an empty blog.');
        return false;
      }
    });
  </script>
</body>
</html>