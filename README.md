# Blogz - A Modern Blog Platform

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Database Design](#database-design)
- [Security Features](#security-features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)

## Overview

Blogz is a full-featured CRUD (Create, Read, Update, Delete) blog application built with PHP and MySQL. It provides a clean, intuitive interface for users to create and manage blog posts, customize their profiles, and interact with content.

## Features

### User Management
- **User Registration**: Secure account creation with email verification
- **User Authentication**: Secure login system with session management
- **Profile Management**: Users can update their profile information, change passwords, and upload profile pictures
- **Account Deletion**: Users can permanently delete their accounts and associated data

### Blog Management
- **Create Posts**: Rich text editor for creating engaging blog posts with thumbnails
- **Read Posts**: Clean, responsive layout for reading blog content
- **Update Posts**: Edit functionality for modifying existing blog content
- **Delete Posts**: Remove unwanted blog posts with confirmation

### User Interface
- **Responsive Design**: Mobile-friendly interface that works across devices
- **Dashboard**: Personalized dashboard showing recent posts
- **My Blogs Page**: Dedicated section for managing user's own blog posts
- **Navigation**: Intuitive navigation with dropdown menus for user actions

## System Architecture

Blogz follows a traditional PHP application architecture:

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache 2.4+

The application is structured as follows:

```
CRUD-app/
├── assets/             # Static assets (images, icons)
├── components/         # Reusable UI components
├── conn/               # Database connection and operations
├── css/                # Stylesheets
├── database/           # Database schema and migrations
├── js/                 # JavaScript files
├── uploads/            # User-uploaded content
└── various PHP files   # Application pages
```

## Database Design

The database schema is designed for optimal performance and data integrity:

```sql
CREATE DATABASE blogz;
USE blogz;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE blogs (
    blog_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    thumbnail_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_blog_user_id ON blogs(user_id);
```

### Database Optimization
- **Indexes**: Strategic indexes on frequently queried columns
- **Foreign Keys**: Proper relationships with cascading deletes
- **Normalization**: Database is in Third Normal Form (3NF).The Blogz database schema achieves Third Normal Form (3NF) because each table contains only attributes that depend on its primary key and nothing else. Every non-key attribute in the Users table (first_name, email, password, profile_picture_url, created_at) depends solely on the user_id, while every attribute in the Blogs table depends exclusively on blog_id, with user_id properly serving as a foreign key to establish the relationship. This design eliminates transitive dependencies by ensuring no attribute depends on another non-key attribute, making the database efficient for updates, preventing anomalies, and maintaining data integrity.


## Security Features

Blogz implements several security measures to protect user data:

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()` with BCRYPT
- **Prepared Statements**: All database queries use PDO prepared statements to prevent SQL injection
- **Input Validation**: Form inputs are validated both client-side and server-side
- **XSS Prevention**: Output is sanitized using `htmlspecialchars()` to prevent cross-site scripting
- **Session Management**: Secure session handling with proper initialization and destruction
- **File Upload Security**: Validation of file types and secure storage of uploaded files
- **Authorization Checks**: Verification of user permissions before allowing actions

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- Composer (optional, for dependencies)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/blogz.git
   cd blogz
   ```

2. **Set up the database**
   ```bash
   mysql -u root -p < database/database-schema.sql
   ```

3. **Configure database connection**
   Edit `conn/db.php` with your database credentials:
   ```php
   $host = 'localhost';
   $db = 'blogz';
   $user = 'your_username';
   $pass = 'your_password';
   ```

4. **Set up the web server**
   Configure your web server to point to the project directory.

5. **Create upload directories**
   ```bash
   mkdir -p uploads
   chmod 755 uploads
   ```

6. **Access the application**
   Open your browser and navigate to `http://localhost/CRUD-app/`

## Configuration

### Database Configuration
Edit `conn/db.php` to change database connection parameters.

### File Upload Settings
File upload settings can be adjusted in the following files:
- `create-post.php` - For blog thumbnails
- `conn/update-profile.php` - For profile pictures

## Usage

### User Registration and Login
1. Navigate to the homepage
2. Click "Register" to create a new account
3. Fill in your details and submit
4. Log in with your email and password

### Creating a Blog Post
1. Log in to your account
2. Click "Create Post" in the navigation bar
3. Add a title, content, and optional thumbnail
4. Click "Publish" to create your post

### Managing Your Profile
1. Click on your profile picture in the top-right corner
2. Select "Profile" from the dropdown menu
3. Use the interface to update your information, change password, or delete account

### Managing Your Blog Posts
1. Click on your profile picture in the top-right corner
2. Select "My Blogs" from the dropdown menu
3. View, edit, or delete your existing blog posts

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

© 2023 Blogz. All rights reserved.