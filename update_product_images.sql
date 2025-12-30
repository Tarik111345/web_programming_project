-- Update existing products with image URLs
-- Run this in phpMyAdmin or MySQL command line
-- You already have these images in frontend/assets/img/

USE hadrofit;

-- Update products with your existing local images
UPDATE products SET image = 'assets/img/protein1.jpg' WHERE name LIKE '%Whey%' OR name LIKE '%Protein%';
UPDATE products SET image = 'assets/img/creatine.jpg' WHERE name LIKE '%Creatine%';
UPDATE products SET image = 'assets/img/bcaa.jpg' WHERE name LIKE '%BCAA%';
UPDATE products SET image = 'assets/img/preworkout.jpg' WHERE name LIKE '%Pre%';
UPDATE products SET image = 'assets/img/vitamins.jpg' WHERE name LIKE '%Vitamin%' OR name LIKE '%Multi%';
UPDATE products SET image = 'assets/img/omega3.jpg' WHERE name LIKE '%Omega%';
UPDATE products SET image = 'assets/img/glutamine.jpg' WHERE name LIKE '%Glutamine%';
UPDATE products SET image = 'assets/img/proteinbar.jpg' WHERE name LIKE '%Bar%';

-- Set default image for any products without images
UPDATE products SET image = 'assets/img/workout.jpg' WHERE image IS NULL OR image = '';

-- Check results
SELECT id, name, price, image FROM products;
