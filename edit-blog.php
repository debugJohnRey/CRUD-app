<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'conn/db.php';

// Get the blog ID from the URL
$blog_id = isset($_GET['id']) ? $_GET['id'] : null;
$user_id = $_SESSION['user_id'];

if (!$blog_id) {
    header("Location: my-blogs-page.php");
    exit();
}

// Check if the blog belongs to the current user
try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE blog_id = ? AND user_id = ?");
    $stmt->execute([$blog_id, $user_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$blog) {
        // Blog doesn't exist or doesn't belong to current user
        header("Location: my-blogs-page.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching blog: " . $e->getMessage());
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Handle thumbnail update
    $thumbnail_url = $blog['thumbnail_url']; // Keep existing thumbnail by default
    
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['thumbnail']['name']);
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadFile)) {
            $thumbnail_url = $uploadFile;
        }
    }
    
    try {
        $sql = "UPDATE blogs SET title = :title, content = :content, thumbnail_url = :thumbnail_url WHERE blog_id = :blog_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':thumbnail_url' => $thumbnail_url,
            ':blog_id' => $blog_id,
            ':user_id' => $user_id
        ]);
        
        // Redirect back to my blogs page after successful update
        header("Location: my-blogs-page.php");
        exit();
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
  <link rel="stylesheet" href="css/edit-blog.css">
  <title>Edit Blog</title>
</head>
<body>
  <?php 
    include 'components/navbar.php';
    
    echo renderNavbar( 
      "Update", 
      "fa-solid fa-circle-check",
      true
    );
  ?>
  
  <div class="textarea-container">
    <form id="createPostForm" method="POST" enctype="multipart/form-data" action="edit-blog.php?id=<?php echo $blog_id; ?>">
        <div id="thumbnail-container">
            <?php if (!empty($blog['thumbnail_url'])): ?>
                <img id="thumbnail" src="<?php echo htmlspecialchars($blog['thumbnail_url']); ?>" alt="Thumbnail">
                <button type="button" id="removeThumbnailButton">X</button>
            <?php else: ?>
                <img id="thumbnail" src="" alt="Thumbnail" style="display: none;">
                <button type="button" id="removeThumbnailButton" style="display: none;">X</button>
            <?php endif; ?>
        </div>
        <button type="button" id="addThumbnailButton"><?php echo !empty($blog['thumbnail_url']) ? 'Change Thumbnail' : 'Add Thumbnail'; ?></button>
        <textarea id="autoResizeTextareaTitle" class="title-textarea" name="title" placeholder="Title"><?php echo htmlspecialchars($blog['title']); ?></textarea>
        <textarea id="autoResizeTextareaContent" class="content-textarea" name="content" placeholder="Tell your story..."><?php echo htmlspecialchars($blog['content']); ?></textarea>
        <input type="file" id="fileInput" name="thumbnail" accept="image/*" style="display: none;">
    </form>
  </div>
  
  <script src="js/scripts.js"></script>
  <script src="js/edit-blog.js"></script>
</body>
</html>