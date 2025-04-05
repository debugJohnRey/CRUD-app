<?php
function renderBlogDetail($blog) {
    return '
    <div class="blog-detail-container">
        <article class="blog-header">
            ' . ($blog['thumbnail_url'] ? '
                <img class="blog-thumbnail" src="' . htmlspecialchars($blog['thumbnail_url'], ENT_QUOTES, 'UTF-8') . '" alt="Blog thumbnail">
            ' : '') . '
            
            <div class="blog-meta">
                <img class="author-avatar" src="' . htmlspecialchars($blog['profile_picture_url'], ENT_QUOTES, 'UTF-8') . '" alt="Author avatar">
                <div class="author-info">
                    <span class="author-name">' . htmlspecialchars($blog['first_name'], ENT_QUOTES, 'UTF-8') . '</span>
                    <span class="blog-date">' . date('M d, Y', strtotime($blog['created_at'])) . '</span>
                </div>
            </div>

            <h1 class="blog-title">' . htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') . '</h1>
        </article>

        <div class="blog-content">
            ' . nl2br(htmlspecialchars($blog['content'], ENT_QUOTES, 'UTF-8')) . '
        </div>
    </div>

    <style>
        .blog-detail-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .blog-header {
            margin-bottom: 40px;
        }

        .blog-thumbnail {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .blog-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .author-info {
            font-size: 14px;
        }

        .author-name {
            color: #1A73E8;
            font-weight: 600;
        }

        .blog-date {
            color: #666;
        }

        .blog-title {
            font-family: "Libre Baskerville", serif;
            font-size: 42px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            line-height: 1.3;
        }

        .blog-content {
            font-family: "Libre Baskerville", serif;
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            white-space: pre-wrap;
        }
    </style>';
}
?>