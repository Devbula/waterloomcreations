SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `shop_db`;
USE `shop_db`;

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(142, 15, 16, 'EcoFlow Slippers', 200, 20, 'product3.png'),
(143, 15, 13, 'Water Lily Comfort Slippers', 150, 20, 'product1.png'),
(146, 30, 13, 'Water Lily Comfort Slippers', 150, 1, 'product1.png'),
(147, 31, 13, 'Water Lily Comfort Slippers', 150, 2, 'product1.png');

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `message`
ADD COLUMN `firstname` VARCHAR(255) NOT NULL,
ADD COLUMN `lastname` VARCHAR(255) NOT NULL,
ADD COLUMN `phone_number` VARCHAR(20) NOT NULL;



INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(14, 14, 'aya payno', 'payno@gmail.com', '09198997144', 'when will you ship my order');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(20, 15, 'aya payno', '01918997144', 'payno@gmail.com', 'cash on delivery', '#19a upper tamaraw, Barangay: marulas, valenzuela city, philippines - 123456', ', Lily Lite Slippers (1) ', 170, '22-Sep-2024', 'pending'),
(21, 24, 'aya payno', '09198897144', 'payno@gmail.com', 'cash on delivery', '#19a upper tamaraw, Barangay: marulas, valenzuela city, Philippines - 123456', ', Water Lily Comfort Slippers (5) , Lily Lite Slippers (1) ', 920, '23-Sep-2024', 'pending');

ALTER TABLE orders ADD COLUMN notes TEXT;

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `products` (`id`, `name`, `details`, `price`, `image`) VALUES
(13, 'Water Lily Comfort Slippers', 'Comfortable slippers crafted from eco-friendly water lily fibers, perfect for home use.', 150, 'product1.png'),
(15, 'Lily Lite Slippers', 'Soft and lightweight water lily slippers, designed for daily comfort and durability.', 170, 'product2.png'),
(16, 'EcoFlow Slippers', 'Stylish and sustainable slippers made from natural water lily materials, ideal for indoor wear', 200, 'product3.png'),
(17, 'Lily Breeze Handwoven Bag', 'Handwoven bag made from durable water lily fibers, perfect for casual outings.', 400, 'product4.png'),
(18, 'Elegant Lily Handbag', 'Elegant handbag featuring a unique water lily weave, combining style and sustainability', 1000, 'product5.png'),
(19, 'Lily Verso Bag', 'Versatile bag made from lightweight water lily fibers, perfect for any occasion.', 700, 'product6.png'),
(20, 'Water Lily Everyday Tote', 'Spacious and eco-conscious tote bag crafted from water lilies, ideal for everyday use.', 500, 'product7.png');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `phone_number` varchar(255) NOT NULL,
  `house_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `user_type`, `phone_number`, `house_number`, `street`, `barangay`, `city`, `state`, `country`, `zip_code`) VALUES
(10, 'admin A', '', 'admin01@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', '', '', '', '', '', ''),
(14, 'user A', '', 'user01@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'user', '', '', '', '', '', '', '', ''),
(15, 'user B', '', 'user02@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'user', '', '', '', '', '', '', '', ''),
(31, 'fer', 'les', 'fer@gmail.com', '71b3b26aaa319e0cdf6fdb8429c112b0', 'user', '+639178897133', '#19A', 'Upper Tamaraw Hills', 'Marulas', 'Valenzuela', 'Metro Manila', 'Philippines', '1440');

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_trail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE audit_trail MODIFY COLUMN description TEXT NOT NULL;


CREATE TABLE payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gcash_number VARCHAR(20),
    paymaya_number VARCHAR(20),
    paypal_email VARCHAR(255),
    card_number VARCHAR(16),
    card_holders_name VARCHAR(255),
    card_expiration VARCHAR(10),
    card_cvv VARCHAR(4),
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);




COMMIT;