# PHP Authentication System
Author: Mert Korur

---

## Overview

A secure authentication system built with plain PHP and MySQL, implementing user registration, login, logout, session-based access control, and common web security best practices.

This project was developed to learn PHP and to understand backend authentication mechanisms without relying on a framework.

---

## Features

- User registration with input validation
- Secure password hashing (`password_hash`, `password_verify`)
- Login and logout with session-based authentication
- CSRF protection for all forms
- Flash messages for user feedback
- Access-protected dashboard
- Clean separation of concerns (validation, repository, bootstrap)

---

## Project Structure
```
php-auth/
├── bootstrap.php
├── config/
│ ├── env.php
│ └── database.php
├── classes/
│ ├── Validator.php
│ └── UserRepository.php
├── public/
│ ├── registration.php
│ ├── login.php
│ ├── dashboard.php
│ └── logout.php
└── README.md
```

---

## Tech Stack

- PHP (no framework)
- MySQL
- PDO (prepared statements)
- Sessions and cookies
- HTML / Bootstrap 5

---

## Security Measures

- CSRF token generation and verification
- Password hashing with `PASSWORD_DEFAULT`
- Session regeneration on login
- Prepared statements to prevent SQL injection
- Output escaping to prevent XSS

---

## Local Development Setup

This project is intended to run locally using **XAMPP**.

### Requirements

- PHP 8+
- MySQL
- XAMPP (Apache + MySQL)

---

### Installation Steps

1. Clone the repository into your XAMPP `htdocs` directory:
   ```bash
   git clone https://github.com/your-username/php-auth-system.git
   ```
2. Start Apache and MySQL via XAMPP Control Panel.
3. Create a MySQL database:
   ```sql
   CREATE DATABASE php_auth;
   ```
4. Create the `users` table:
   ```sql
   CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```
5. Configure environment variables in `config/env.php`:
   ```php
   <?php
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_NAME'] = 'php_auth';
    $_ENV['DB_USER'] = 'root';
    $_ENV['DB_PASS'] = '';
   ```
6. Open the application in your browser:
   `http://localhost/php-auth/public/registration.php`

---

### Usage

- Register a new user
- Log in using your credentials
- Access the protected dashboard
- Log out to end the session

---

### Learning Goals

This project focuses on:
- Understanding authentication flows without frameworks
- Writing secure PHP code
- Applying backend architecture patterns
- Preparing for framework-based development (e.g. Laravel)
