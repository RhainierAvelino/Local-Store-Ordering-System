# Local Store Ordering System

A PHP and MySQL ordering system for a local food store. The project includes customer-facing shopping features and an administrator area for managing products, orders, accounts, and customer messages.

## Features

### Customer side

- User registration and login
- Product browsing and search
- Product quick view
- Shopping cart management
- Checkout and order placement
- Profile and delivery-address updates
- Customer message submission

### Administrator side

- Admin registration and account management
- Product management
- Order and payment-status management
- Customer-message viewing
- Administrative dashboard

## Technology stack

- PHP
- MySQL / MariaDB
- HTML
- CSS
- JavaScript
- PDO

## Project structure

```text
LocalStoreSystem/
├── admin/
├── components/
├── uploaded_img/
├── home.php
├── cart.php
├── checkout.php
├── quick_view.php
├── search.php
├── register.php
├── profile.php
└── food_db.sql
```

## Requirements

- PHP 8 or compatible version
- MySQL or MariaDB
- A local server environment such as XAMPP, WAMP, or Laragon

## Setup

1. Clone or download the repository.
2. Copy `LocalStoreSystem` into your local web server directory, such as `htdocs` when using XAMPP.
3. Start Apache and MySQL.
4. Create a database named `food_db`.
5. Import:

```text
LocalStoreSystem/food_db.sql
```

6. Confirm the local database configuration in:

```text
LocalStoreSystem/components/connect.php
```

7. Open the application in your browser, for example:

```text
http://localhost/LocalStoreSystem/home.php
```

## Demonstration data notice

The included SQL file contains sample development records for local testing. Do not reuse the demonstration credentials or sample data in a production deployment.

## Security note

This is an academic prototype. A production version should use environment variables, stronger authentication controls, modern password hashing, validation, CSRF protection, and stricter database security.

## Project status

Academic full-stack web application created to practice PHP, relational database integration, customer ordering workflows, and administrator operations.

## Author

**Rhainier L. Avelino**  
Bachelor of Science in Information Technology  
Polytechnic University of the Philippines
