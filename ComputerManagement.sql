CREATE DATABASE COMPUTERMANAGEMENT;

USE COMPUTERMANAGEMENT;
-- Tạo bảng customer
CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    firstname VARCHAR(255),
    middlename VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    img VARCHAR(255) NULL,
    password VARCHAR(255),
    row_delete TINYINT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tạo bảng user
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    firstname VARCHAR(255),
    middlename VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    img VARCHAR(255) NULL,
    password VARCHAR(255),
    role tinyINT,
    row_delete TINYINT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tạo bảng category
CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255),
    description TEXT NULL,
    parentID INT,
    row_delete TINYINT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tạo bảng product
CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255),
    price_in DOUBLE,
    price_out DOUBLE,
    hot TINYINT,
    ram INT,
    storage INT,
    quantity INT,
    display_size DECIMAL(4, 2),
    row_delete TINYINT,
    created_at TIMESTAMP NULL,
	image_url VARCHAR(255),
    updated_at TIMESTAMP NULL
);

-- Tạo bảng product_category
CREATE TABLE product_category (
    product_category_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    category_id INT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES product (product_id),
    FOREIGN KEY (category_id) REFERENCES category (category_id)
);

-- Tạo bảng order
CREATE TABLE `order` (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    description TEXT NULL,
    status VARCHAR(255),
    total_order DOUBLE(8,2),
    row_delete TINYINT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customer (customer_id)
);

-- Tạo bảng order_detail
CREATE TABLE order_detail (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DOUBLE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    row_delete TINYINT,
    FOREIGN KEY (order_id) REFERENCES `order` (order_id),
    FOREIGN KEY (product_id) REFERENCES product (product_id)
);
