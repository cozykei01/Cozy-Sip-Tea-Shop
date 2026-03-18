-- 1. Users Table =========================================================================================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    full_name VARCHAR(150),
    role VARCHAR(50),
    email VARCHAR(150) UNIQUE,
    contact VARCHAR(50),
    point_balance INT DEFAULT 0
);

-- 2. Product Categories Table =========================================================================================
CREATE TABLE product_categories (
    product_category_id INT AUTO_INCREMENT PRIMARY KEY,
    product_category_name VARCHAR(100) NOT NULL
);

INSERT INTO product_categories (product_category_name) VALUES
('Basic Coffee'),
('Cold Coffee'),
('Tea & Non-Coffee'),
('Specialty Drinks'),
('Bakery & Snacks');

-- 3. Events Table =========================================================================================
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    start_date DATETIME,
    end_date DATETIME,
    is_active BOOLEAN DEFAULT TRUE
);

-- 4. Promotions Table =========================================================================================
CREATE TABLE promotions (
    promotion_id INT AUTO_INCREMENT PRIMARY KEY,
    promotion_name VARCHAR(150) NOT NULL,
    promotion_type VARCHAR(50),
    start_date DATETIME,
    end_date DATETIME
);

-- 5. Products Table =========================================================================================
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_name VARCHAR(150) NOT NULL,
    quantity INT DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    event_price DECIMAL(10, 2),
    earned_point_value INT DEFAULT 0,
    event_status BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (category_id) REFERENCES product_categories(product_category_id) ON DELETE SET NULL
);

-- 6. Orders Table =========================================================================================
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_quantity INT DEFAULT 0,
    earned_points INT DEFAULT 0,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 7. Order Detail Table =========================================================================================
CREATE TABLE order_details (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT
);

-- 8. Payments Table =========================================================================================
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_method VARCHAR(50), -- (e.g., K-pay, Wave pay)
    payment_status VARCHAR(50), -- (e.g., Pending, Completed, Failed)
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

-- 9. Point Transaction Table =========================================================================================
CREATE TABLE point_transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_id INT NULL,
    points INT NOT NULL,
    transaction_type VARCHAR(50), -- (e.g., Earned, Redeemed)
    event_id INT NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE SET NULL
);

-- 10. Promotion Items Table =========================================================================================
CREATE TABLE promotion_items (
    promotion_item_id INT AUTO_INCREMENT PRIMARY KEY,
    promotion_id INT,
    product_id INT,
    FOREIGN KEY (promotion_id) REFERENCES promotions(promotion_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- 11. Exchange Product Table =========================================================================================
CREATE TABLE exchange_products (
    exchange_product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    points_required INT NOT NULL,
    stock_quantity INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- 12. Exchange Table =========================================================================================
CREATE TABLE exchanges (
    exchange_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    exchange_product_id INT,
    points_spent INT NOT NULL,
    exchange_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (exchange_product_id) REFERENCES exchange_products(exchange_product_id) ON DELETE RESTRICT
);