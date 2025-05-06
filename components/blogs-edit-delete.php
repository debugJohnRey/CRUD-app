<?php
function editDeleteBlogs($blogs) {
  $html = '<div class="blog-container">';

    foreach ($blogs as $blog) {
      // Set default profile picture if none exists
      $profilePicture = !empty($blog['profile_picture_url']) ? $blog['profile_picture_url'] : 'assets/user.png';
      
      $html .= '
      <div class="card">
          <div class="content" onclick="window.location.href=\'blog-detail.php?id=' . htmlspecialchars($blog['blog_id'], ENT_QUOTES, 'UTF-8') . '\'">
              <div class="author-section">
                  <img class="avatar" src="' . htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') . '" alt="Avatar">
                  <p class="author"><span class="name">' . htmlspecialchars($blog['first_name'], ENT_QUOTES, 'UTF-8') . '</span> / <span class="date">' . date('M d, Y', strtotime($blog['created_at'])) . '</span></p>
              </div>
              <h2>' . htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') . '</h2>
          </div>
          <div class="action-buttons">
              <button class="edit-btn" onclick="event.stopPropagation(); window.location.href=\'edit-blog.php?id=' . htmlspecialchars($blog['blog_id'], ENT_QUOTES, 'UTF-8') . '\'">
                  <i class="fas fa-edit"></i> Edit
              </button>
              <button class="delete-btn" onclick="event.stopPropagation(); if(confirm(\'Are you sure you want to delete this blog?\')) window.location.href=\'delete-blog.php?id=' . htmlspecialchars($blog['blog_id'], ENT_QUOTES, 'UTF-8') . '\'">
                  <i class="fas fa-trash"></i> Delete
              </button>
          </div>
      </div>
      <style>
          .action-buttons {
              position: absolute;
              right: 20px;
              top: 50%;
              transform: translateY(-50%);
              display: flex;
              gap: 10px;
          }
          
          .edit-btn, .delete-btn {
              padding: 5px 10px;
              border: none;
              border-radius: 4px;
              cursor: pointer;
              font-size: 12px;
              display: flex;
              align-items: center;
              gap: 5px;
          }
          
          .edit-btn {
              background-color: #4993af;
              color: white;
          }
          
          .delete-btn {
              background-color: #dc3545;
              color: white;
          }
          
          .card {
              position: relative;
          }
      </style>';
  }

  $html .= '</div>';

  return $html . '
    <style>
      * {
        font-family: "Inter", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
      }

      .blog-container {
          margin-left: 50px;
          margin-right: 50px;
          margin-top: 40px;
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 20px;
      }

      .card {
          width: 100%;
          height: 110px;
          background: white;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          border-radius: 12px;
          overflow: hidden;
          cursor: pointer;
          margin: 5px;
      }

      .content {
          padding: 20px;
      }

      .content .author-section {
          display: flex;
          align-items: center;
          margin-bottom: 10px;
      }

      .content .author-section img.avatar {
          width: 30px;
          height: 30px;
          border-radius: 50%;
          border: 1px solid #ddd;
          margin-right: 10px;
      }

      .content .author-section p.author {
          font-size: 12px;
          margin: 0;
      }

      .content .author-section p.author span.name {
          color: rgb(76, 147, 175);
          font-weight: 600;
      }

      .content .author-section p.author span.date {
          color: #666;
      }

      .content h2 {
          font-size: 16px;
          font-weight: 500;
          margin: 10px 0;
          color: #000;
      }

      .content p.subheading {
          font-size: 14px;
          color: #666;
          margin: 0;
      }
    </style>
  ';
}
?> 