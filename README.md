Frontend (Single Page App)

-The frontend is made as a single-page application using jQuery SPApp for routing. All pages load inside the main content without refreshing the whole page. Navigation works with hash URLs.

Pages included in this milestone:

-Home

-Products List

-Cart

-Checkout

-Dashboard

-Login

-Register

Bootstrap 5 is used for layout and responsiveness, so the design works on desktop and mobile.

What is finished in Milestone 1

-Project structure is separated into frontend and backend folders

-Each page is in a separate HTML file

-Navigation works without page reload

LocalStorage is used for:

-user registration

-login

-cart items

-dashboard data

-Navbar navigation works correctly

-Products are displayed with modals

-Cart and checkout work with basic simulation

-Login redirects to a simple user dashboard

ERD

The ERD is saved in a separate file called ERD.md.

Planned entities:

-Users

-Products

-Categories

-Orders

-Order Items

-Reviews

How to run the frontend
Option 1: Live Server (VS Code)

-Open index.html using Live Server

Option 2: XAMPP (localhost)

-http://localhost/hadrofit/frontend/index.html


Milestone 3 – Full CRUD Implementation & Swagger API
Description

In Milestone 3, the backend was extended with a Service Layer, Routes, and OpenAPI (Swagger) documentation.
Now, every entity supports full CRUD operations with RESTful endpoints that are automatically documented in Swagger UI.

What Was Done

Implemented Service Layer for each entity (UserService, ProductService, CategoryService, CartService, OrderService, PaymentService).

Each service handles validation, business logic, and database communication.

- You can test services with http://localhost/hadrofit/backend/test_services.php

Created Routes using FlightPHP for all CRUD operations.

Added @OA annotations for every endpoint to generate OpenAPI docs.

Installed dependencies:

composer require flightphp/core
composer require zircote/swagger-php:^3.3


Created and configured Swagger documentation:

doc_setup.php → API info (title, version, contact)

swagger.php → generates JSON documentation

index.php → renders Swagger UI

Swagger Details

Base URL: http://localhost/hadrofit/backend

Swagger UI: http://localhost/hadrofit/backend/public/v1/docs/

Swagger JSON: http://localhost/hadrofit/backend/public/v1/docs/swagger.php

OpenAPI Version: 3.0.0

Example Endpoints

Users

Method	Endpoint	Description
GET	/api/users	Get all users
GET	/api/users/{id}	Get user by ID
POST	/api/users	Add a new user
PUT	/api/users/{id}	Update user
DELETE	/api/users/{id}	Delete user

Products

Method	Endpoint	Description
GET	/api/products	Get all products
GET	/api/products/{id}	Get product by ID
POST	/api/products	Add new product
PUT	/api/products/{id}	Update product
DELETE	/api/products/{id}	Delete product

(Similar CRUD structure for Categories, Cart, Orders, and Payments.)

Technologies Used

FlightPHP – micro PHP framework for routing

PDO (PHP Data Objects) – database access

Swagger / OpenAPI – API documentation

Composer – dependency management

XAMPP – local server environment

How to Run

Start XAMPP → Apache + MySQL

Clone the repo into htdocs:

cd xampp/htdocs
git clone https://github.com/yourusername/hadrofit.git


Run:

cd hadrofit/backend
composer install


Import hadrofit_db.sql into phpMyAdmin

Open browser:

Swagger UI → http://localhost/hadrofit/backend/public/v1/docs/

Test API → Postman or browser
Milestone 2 – Backend Setup & DAO Layer

Description:
In this milestone, I developed the backend part of the project and connected it with the MySQL database.
The main goal was to implement the DAO (Data Access Object) layer to handle communication with the database in a clean, secure, and structured way. This layer allows the system to perform all basic CRUD operations — Create, Read, Update, and Delete.

What has been done:

- Created a new MySQL database called hadrofit_db with seven main entities:
users, categories, products, cart, orders, order_items, and payments.
- Added an SQL file containing all table creation commands and initial test data.
- Implemented config.php using PDO for secure and reliable database connection.
- Created BaseDAO.php that includes reusable CRUD functions to simplify database operations.
- Developed individual DAO classes for main entities such as UserDAO.php, ProductDAO.php, CategoryDAO.php, and OrderDAO.php.
- Created and ran test.php to verify that all DAO methods and database connections work correctly — all tests passed successfully.

Files:
/backend/rest/dao/config.php
/backend/rest/dao/BaseDAO.php
/backend/rest/dao/UserDAO.php
/backend/rest/dao/ProductDAO.php
/backend/rest/dao/CategoryDAO.php
/backend/rest/dao/OrderDAO.php
/backend/test.php
/database/hadrofit_db.sql

The backend setup and DAO layer were successfully implemented. The project is now connected to the database through PDO, and the DAO pattern ensures clean code organization, better security, and easier database management.

To run test.php we I used: http://localhost/hadrofit/backend/rest/test.php
