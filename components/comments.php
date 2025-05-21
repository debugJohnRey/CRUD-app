<?php
function renderComments($comments, $blog_id, $current_user_id)
{
     $html = '
    <div class="comments-section">
        <h3 class="comments-title">Comments (' . count($comments) . ')</h3>';

     if ($comments) {
          $html .= '<div class="comments-list">';
          foreach ($comments as $comment) {
               $profilePicture = !empty($comment['profile_picture_url']) ? $comment['profile_picture_url'] : 'assets/user.png';

               $html .= '
            <div class="comment-item">
                <div class="comment-avatar">
                    <img src="' . htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($comment['first_name'], ENT_QUOTES, 'UTF-8') . '\'s avatar">
                </div>
                <div class="comment-content">
                    <div class="comment-header">
                        <span class="comment-author">' . htmlspecialchars($comment['first_name'], ENT_QUOTES, 'UTF-8') . '</span>
                        <span class="comment-date">' . date('M d, Y - h:i A', strtotime($comment['created_at'])) . '</span>';

               // Show delete option if the comment belongs to the current user
               if ($comment['user_id'] == $current_user_id) {
                    $html .= '
                        <a href="conn/submit_comment.php?action=delete&comment_id=' . $comment['comment_id'] . '&blog_id=' . $blog_id . '" class="comment-delete" onclick="return confirm(\'Are you sure you want to delete this comment?\')">
                            <i class="fas fa-trash"></i>
                        </a>';
               }

               $html .= '
                    </div>
                    <div class="comment-text">' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) . '</div>
                </div>
            </div>';
          }
          $html .= '</div>';
     } else {
          $html .= '<p class="no-comments">No comments yet. Be the first to comment!</p>';
     }

     // Add comment form
     $html .= '
    <div class="comment-form-container">
        <h4>Leave a Comment</h4>
        <form id="commentForm" action="conn/submit_comment.php" method="post">
            <input type="hidden" name="blog_id" value="' . $blog_id . '">
            <textarea name="content" placeholder="Write your comment..." required></textarea>
            <button type="submit" class="comment-submit-btn">Post Comment</button>
        </form>
    </div>';

     return $html . '
    <style>
        .comments-section {
            max-width: 800px;
            margin: 60px auto 40px;
            padding: 0 20px;
        }

        .comments-title {
            font-family: "Libre Baskerville", serif;
            font-size: 24px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .comments-list {
            margin-bottom: 40px;
        }

        .comment-item {
            display: flex;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .comment-avatar {
            flex-shrink: 0;
            margin-right: 15px;
        }

        .comment-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .comment-content {
            flex-grow: 1;
        }

        .comment-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .comment-author {
            font-weight: 600;
            color: rgb(76, 147, 175);
            margin-right: 10px;
        }

        .comment-date {
            font-size: 12px;
            color: #888;
        }

        .comment-text {
            line-height: 1.5;
            color: #444;
        }

        .no-comments {
            color: #888;
            font-style: italic;
            margin-bottom: 30px;
        }

        .comment-form-container {
            margin-top: 30px;
        }

        .comment-form-container h4 {
            font-family: "Libre Baskerville", serif;
            font-size: 18px;
            margin-bottom: 15px;
        }

        #commentForm textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            resize: vertical;
            font-family: "Inter", sans-serif;
            font-size: 14px;
        }

        #commentForm textarea:focus {
            outline: none;
            border-color: rgb(76, 147, 175);
        }

        .comment-submit-btn {
            background-color: rgb(76, 147, 175);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .comment-submit-btn:hover {
            background-color: rgb(59, 125, 150);
        }

        .comment-delete {
            margin-left: auto;
            color: #dc3545;
            font-size: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .comment-delete:hover {
            opacity: 1;
        }
    </style>';
}
