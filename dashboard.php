<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'conn/db.php'; // Add this to define $pdo globally
include 'conn/fetch_blog.php';
$blogs = fetchBlogs();
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
  <link rel="icon" href="assets/logo.png" type="image/png">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/blog-card.css">
  <title>Blogz</title>
</head>
<body>
<?php 
    include 'components/navbar.php';
    include 'components/blogs.php';

    echo renderNavbar( 
      "Create Post", 
      "fa-regular fa-pen-to-square",
      false
    );

    echo renderBlogCards($blogs);
  ?>

  <script src="js/scripts.js"></script>
</body>
</html>