<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <p>Email: johnrey@gmail.com</p>
    </div>
    
    <div class="profile-info">
      <p>Username: </p>
      <input type="text" class="profile-info-details">
      <p>Password: </p>
      <input type="text" class="profile-info-details">
      <p>Date Joined: </p>
      <input type="text" class="profile-info-details">

      <div    class="profile-buttons-container">
        <button class="edit-profile-button">Edit Profile</button>
        <button class="delete-account-button">Delete Account</button>
      </div>
    </div>
  </div> 
</body>
</html>
