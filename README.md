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
