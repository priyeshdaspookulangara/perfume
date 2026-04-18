-- KOEN E-Commerce Database Schema
-- Compatible with MySQL / MariaDB

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_url` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--
INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Pour Homme', 'homme'),
(2, 'Pour Femme', 'femme'),
(3, 'Gift Sets', 'gifts'),
(4, 'The Atelier', 'atelier');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `scent_family` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `rating` decimal(3,1) DEFAULT 0.0,
  `review_count` int(11) DEFAULT 0,
  `image` text DEFAULT NULL,
  `scent_story` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `top_notes` varchar(255) DEFAULT NULL,
  `heart_notes` varchar(255) DEFAULT NULL,
  `base_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--
INSERT INTO `products` (`category_id`, `name`, `scent_family`, `price`, `compare_price`, `badge`, `rating`, `review_count`, `image`, `scent_story`, `description`, `top_notes`, `heart_notes`, `base_notes`) VALUES
(1, 'Intense Man', 'Woody Oriental', 899.00, 1500.00, 'Bestseller', 4.8, 124, 'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=600&q=80', 'A commanding presence wrapped in dark woods and spice.', 'Premium oil-based perfume for men.', 'Bergamot, Black Pepper', 'Oud, Rose', 'Sandalwood, Musk'),
(2, 'Velvet Rose', 'Floral', 799.00, 1200.00, 'New', 4.9, 86, 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80', 'The morning dew on a blooming rose garden.', 'Elegant floral scent for women.', 'Pink Pepper, Litchi', 'Damask Rose', 'White Musk'),
(1, 'Saffron Dusk', 'Spicy', 949.00, 1600.00, 'Limited', 4.7, 42, 'https://images.unsplash.com/photo-1594035910387-fea47794261f?w=600&q=80', 'A smoky, spicy trail of saffron.', 'Bold and mysterious scent.', 'Saffron, Cinnamon', 'Leather', 'Tobacco'),
(2, 'Midnight Jasmine', 'Floral Oriental', 849.00, 1400.00, '', 4.6, 95, 'https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=600&q=80', 'Intoxicating night-blooming jasmine.', 'Sensual and radiant floral.', 'Neroli', 'Jasmine', 'Vanilla'),
(1, 'Royal Oud', 'Woody', 1299.00, 2000.00, 'Premium', 5.0, 56, 'https://images.unsplash.com/photo-1547332080-60b69a84a605?w=600&q=80', 'Ultimate expression of Assam oud.', 'Power and timeless elegance.', 'Lemon, Pink Berry', 'Cedar', 'Oud, Sandalwood'),
(2, 'Citrus Bloom', 'Fresh', 699.00, 1000.00, 'Popular', 4.5, 78, 'https://images.unsplash.com/photo-1512290923902-8a9f81dc2069?w=600&q=80', 'A burst of sunshine and blossoms.', 'Light and airy fresh scent.', 'Grapefruit, Lemon', 'Magnolia', 'White Woods');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--
CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `ml` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_sizes` (`product_id`, `ml`, `price`, `stock`) VALUES
(1, 5, 499.00, 50), (1, 10, 899.00, 100), (1, 30, 2199.00, 20),
(2, 5, 449.00, 50), (2, 10, 799.00, 100), (2, 30, 1899.00, 20),
(3, 5, 549.00, 50), (3, 10, 949.00, 100), (3, 30, 2399.00, 20),
(4, 5, 499.00, 50), (4, 10, 849.00, 100), (4, 30, 2099.00, 20),
(5, 5, 699.00, 50), (5, 10, 1299.00, 100), (5, 30, 3200.00, 20),
(6, 5, 399.00, 50), (6, 10, 699.00, 100), (6, 30, 1699.00, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin: admin@koen.in / admin123
-- User: priya@gmail.com / test123
INSERT INTO `users` (`name`, `email`, `password`, `is_admin`) VALUES
('Administrator', 'admin@koen.in', '$2y$10$89EwF0mDqQ4eG5R6W7Z8UuX1Y2Z3A4B5C6D7E8F9G0H1I2J3K4L5M', 1),
('Priya Sharma', 'priya@gmail.com', '$2y$10$UuVvWwXxYyZz11223344556677889900AABBCCddeeffgghhiijj', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address1` text NOT NULL,
  `address2` text DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `shipping_fee` decimal(10,2) DEFAULT 0.00,
  `final_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Placed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_ml` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `type` enum('percent','fixed') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `min_order` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `coupons` (`code`, `type`, `value`, `min_order`) VALUES
('KOEN10', 'percent', 10.00, 500.00),
('WELCOME20', 'percent', 20.00, 0.00),
('FLAT100', 'fixed', 100.00, 799.00);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--
CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_product` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
