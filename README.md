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



# Hadrofit - Milestone 4: Authentication & Authorization

## Implemented Features

### Backend
- JWT authentication (register/login endpoints)
- Password hashing with bcrypt
- Authentication middleware
- Role-based access control (admin/user)
- Protected API routes
- Complete CRUD API for products

### Frontend
- Login/Register forms connected to backend API
- JWT token storage in localStorage
- Role-based UI (admin panel visibility)
- User dashboard with authentication

## Known Issues
- Frontend CRUD operations encounter header transmission issue between jQuery and Apache
- Backend API fully functional (tested via direct API calls)
- Workaround: API endpoints accessible via tools like Postman

## Testing
1. Register: `/auth/register`
2. Login: `/auth/login` 
3. Access protected routes with JWT token in `Authentication` header

## Technologies
- Backend: PHP, FlightPHP, JWT, MySQL
- Frontend: jQuery, Bootstrap 5, SPApp

---

## Milestone 5: Frontend Validations & Production Deployment

**Live Application:** https://hadrofit-vxizr.ondigitalocean.app/

### Milestone 4 Issues Fixed

In Milestone 4, there were issues with frontend CRUD operations due to header transmission problems between jQuery and Apache. These have been completely resolved:

- Refactored API calls to use proper `$.ajax()` configuration
- Fixed JWT token transmission in Authorization headers
- Implemented BlockUI for better user feedback
- Added error handling with detailed messages
- All CRUD operations (Create, Read, Update, Delete) now work correctly
- Admin panel is fully functional

### What Was Implemented

#### 1. Frontend Validations
- Client-side validation using jQuery Validation Plugin
- Validation rules:
  - Name: minimum 3 characters
  - Email: valid email format
  - Password: 6-20 characters
  - Product price: must be positive
  - Product stock: cannot be negative
  - Category ID: valid positive integer
- Real-time validation feedback
- Form submission blocked until validation passes

#### 2. User Experience
- Loading indicators during API calls (BlockUI)
- Success/error alerts with messages from backend
- Smooth page transitions
- Responsive design for mobile and desktop

#### 3. Production Deployment

**Infrastructure:**
- Platform: DigitalOcean App Platform
- Database: DigitalOcean Managed MySQL Database
- Containerization: Docker
- Web Server: Apache 2.4 with PHP 8.1
- Security: HTTPS/SSL
- CI/CD: Auto-deployment from GitHub

**Configuration:**
- Environment variables for production (DB credentials, JWT secret)
- Updated config.php to support environment variables
- Separate configurations for development and production

**Database (Production):**
- Host: hadrofit-db-do-user-31164408-0.h.db.ondigitalocean.com
- Port: 25060
- Database: hadrofit
- Connection: PDO with SSL/TLS

### Deployment Steps

1. Created DigitalOcean Managed MySQL Database
2. Imported database schema and data
3. Updated config.php for environment variables
4. Created Dockerfile for PHP + Apache + MySQL PDO
5. Created apache-config.conf for routing
6. Configured App Platform environment variables
7. Connected GitHub repository (milestone5 branch)
8. Enabled auto-deployment on push
9. Updated frontend API URLs to production
10. Fixed case-sensitive file issue (roles.php to Roles.php)
11. Tested all features in production

### Note on Production Database

The production database currently contains 2 products (Multivitamins and Creatine Monohydrate) for demonstration purposes. This limited dataset was used to verify all functionality works correctly, which is common practice for initial deployments.

Despite having only 2 products, the application demonstrates all required features:
- Database connectivity to cloud
- All REST API operations (GET, POST, PUT, DELETE)
- User registration and login with JWT
- Role-based access control
- CRUD operations via Admin Panel
- Client and server-side validations
- Frontend-backend integration
- Responsive design
- 24/7 availability

Additional products can be added through the Admin Panel, database import, or API calls.

### Testing the Application

**Production URL:** https://hadrofit-vxizr.ondigitalocean.app/

**Registration:**
1. Click "Register"
2. Fill form with validation
3. User created in cloud database

**Login:**
1. Enter credentials
2. JWT token stored in localStorage
3. Redirected to dashboard

**Products Page:**
1. Navigate to "Products"
2. View products loaded from API
3. Data fetched from cloud database

**Admin Panel** (if admin user exists):
1. Login as admin
2. Add/edit/delete products
3. Changes persist in database

### Technologies

**Frontend:** HTML5, CSS3, JavaScript, jQuery, Bootstrap 5, jQuery SPApp, jQuery Validation, jQuery BlockUI

**Backend:** PHP 8.1, FlightPHP, JWT, PDO, MySQL

**DevOps:** Docker, DigitalOcean App Platform, DigitalOcean Managed Database, GitHub, Apache 2.4, SSL/TLS

### Summary

Milestone 5 delivers a fully functional e-commerce application deployed on DigitalOcean with complete frontend-backend integration, JWT authentication, role-based authorization, CRUD operations, validations, and auto-deployment from GitHub.