DROP DATABASE IF EXISTS hadrofit_db;
CREATE DATABASE hadrofit_db;
USE hadrofit_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'paid', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    method ENUM('credit_card', 'paypal', 'cash_on_delivery') DEFAULT 'cash_on_delivery',
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    transaction_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@hadrofit.com', 'admin123', 'admin'),
('Tarik Hadrović', 'tarik@hadrofit.com', 'password123', 'admin'),
('Emir Segic', 'emir@hadrofit.com', 'password123', 'user');

INSERT INTO categories (name, description) VALUES
('Proteins', 'Protein supplements for muscle growth'),
('Vitamins', 'Essential vitamins and minerals'),
('Pre-Workout', 'Energy boosters for training'),
('Amino Acids', 'BCAAs and recovery supplements'),
('Health Supplements', 'Omega 3 and wellness products');

INSERT INTO products (category_id, name, description, price, image, stock) VALUES
(1, 'Whey Protein', 'High-quality whey protein. 24g protein per serving.', 29.99, 'assets/img/protein1.jpg.png', 50),
(2, 'Multivitamins', 'Daily essential vitamins and minerals.', 19.99, 'assets/img/vitamins.jpg.png', 100),
(1, 'Creatine Monohydrate', 'Boost strength and endurance. 5g per serving.', 24.99, 'assets/img/creatine.jpg.png', 75),
(4, 'BCAA', 'Branched-chain amino acids. 6g BCAA per serving.', 21.99, 'assets/img/bcaa.jpg.png', 60),
(3, 'Pre-Workout', 'Increase energy and focus. 200mg caffeine.', 27.99, 'assets/img/preworkout.jpg.png', 40),
(5, 'Omega 3', 'Supports heart and brain health. 1000mg fish oil.', 17.99, 'assets/img/omega3.jpg.png', 80),
(4, 'Glutamine', 'Muscle recovery and immune support. 5g per serving.', 22.99, 'assets/img/glutamine.jpg.png', 55),
(1, 'Protein Bar', 'High-protein snack. 20g protein per bar.', 9.99, 'assets/img/proteinbar.jpg.png', 120);

SELECT 'Database created successfully!' AS status;

SELECT 'users' AS table_name, COUNT(*) AS records FROM users
UNION ALL
SELECT 'categories', COUNT(*) FROM categories
UNION ALL
SELECT 'products', COUNT(*) FROM products
UNION ALL
SELECT 'cart', COUNT(*) FROM cart
UNION ALL
SELECT 'orders', COUNT(*) FROM orders
UNION ALL
SELECT 'order_items', COUNT(*) FROM order_items
UNION ALL
SELECT 'payments', COUNT(*) FROM payments;

show TABLES;
describe users;
describe products;
describe orders;
select * from users;
select * from categories;
select * from products;
