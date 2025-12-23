# Bookstore Web Application

A PHP + MySQL bookstore project that lets users browse books, manage a cart, and place orders. It also includes an admin area for managing products, users, and orders.

## Features

User
- Browse all books and search by title/author
- View book details
- Add to cart and checkout
- View order history and dashboard
- Contact form

Admin
- Manage books (add, edit, delete)
- Manage users
- Manage orders and payment status
- View contact messages

## Tech Stack

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL (phpMyAdmin recommended)

## Setup

1) Clone or place the project into your local server root
- XAMPP: `htdocs/project`

2) Import the database
- Create a database named `shop_db`
- Import `shop_db.sql`

3) Configure database credentials
- Edit `includes/config.php`
```php
$host = "localhost";
$user = "root";
$pass = ""; // Set your MySQL password if needed
$db = "shop_db";
$port = 3306;
```

4) Run the app
- Start Apache and MySQL
- Open `http://localhost/project/pages/login.php`

## Admin Access

If you do not have an admin account yet, create a user in the `users` table and set `user_type` to `admin`. Then log in from `pages/login.php`.

## Project Structure

```
project/
├── admin/                # Admin pages (products, users, orders)
├── assets/               # CSS, JS, images
├── includes/             # Shared config/header/footer
├── pages/                # User pages
├── uploaded_img/         # Uploaded product images
├── shop_db.sql            # Database schema/data
└── README.md
```

## Team Members

- Tạ Thanh Vũ - ITITIU21352
- Lê Quang Nguyên - ITITIU21265
- Lê Ngô Gia Bảo - ITITIU21159
