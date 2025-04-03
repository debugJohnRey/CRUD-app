<?php
function fetchBlogs() {
    $host = 'localhost';
    $db = 'blogz';
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            SELECT blogs.blog_id, blogs.title, blogs.content, blogs.thumbnail_url, blogs.created_at, users.first_name, users.profile_picture_url
            FROM blogs
            JOIN users ON blogs.user_id = users.user_id
            ORDER BY blogs.created_at DESC
        ");

        $stmt->execute();
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $blogs;

    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}