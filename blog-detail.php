<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'conn/db.php';
include 'conn/comments.php';

// Get the blog ID from the URL
$blog_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$blog_id) {
    header("Location: dashboard.php");
    exit();
}

// Fetch the blog details
try {
    $stmt = $pdo->prepare("
        SELECT blogs.*, users.first_name, users.profile_picture_url
        FROM blogs
        JOIN users ON blogs.user_id = users.user_id
        WHERE blog_id = ?
    ");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        header("Location: dashboard.php");
        exit();
    }

    // Fetch comments for this blog
    $comments = fetchComments($blog_id);
} catch (PDOException $e) {
    die("Could not fetch blog details: " . $e->getMessage());
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
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="icon" href="assets/logo.png" type="image/png">
    <link rel="stylesheet" href="css/styles.css">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
</head>

<body> <?php
        include 'components/navbar.php';
        include 'components/blog-detail.php';
        include 'components/comments.php';

        echo renderNavbar("Create Post", "fa-regular fa-pen-to-square", false);
        echo renderBlogDetail($blog);
        echo renderComments($comments, $blog_id, $_SESSION['user_id']);
        ?> <script src="js/scripts.js"></script>
    <script src="js/comments.js"></script>
</body>

</html>