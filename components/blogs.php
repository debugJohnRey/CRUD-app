<?php
function renderBlogCards($blogs) {
    $html = '<div class="blog-container">';

    foreach ($blogs as $blog) {
        $html .= '
        <div class="card" onclick="window.location.href=\'blog-detail.php?id=' . htmlspecialchars($blog['blog_id'], ENT_QUOTES, 'UTF-8') . '\'">
            <div class="banner">
                <img src="' . htmlspecialchars($blog['thumbnail_url'], ENT_QUOTES, 'UTF-8') . '" alt="Banner Image">
            </div>
            <div class="content">
                <div class="author-section">
                    <img class="avatar" src="' . htmlspecialchars($blog['profile_picture_url'], ENT_QUOTES, 'UTF-8') . '" alt="Avatar">
                    <p class="author"><span class="name">' . htmlspecialchars($blog['first_name'], ENT_QUOTES, 'UTF-8') . '</span> / <span class="date">' . date('M d, Y', strtotime($blog['created_at'])) . '</span></p>
                </div>
                <h2>' . htmlspecialchars($blog['title'], ENT_QUOTES, 'UTF-8') . '</h2>
            </div>
        </div>';
    }

    $html .= '</div>';

    return $html . '
        <style>
        .blog-container {
            margin-left: 50px;
            margin-right: 50px;
            margin-top: 40px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        * {
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
        }

        .card {
            width: 20%;
            height: 280px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            margin: 5px;
        }

        .banner {
            height: 160px;
        }

        .banner img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
            transition: opacity 0.3s ease; 
            border-radius: 12px;
        }

        .card:hover .banner img {
            opacity: 0.8; 
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
            color: #1A73E8;
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