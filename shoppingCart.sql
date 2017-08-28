CREATE TABLE `product` (  
    `id` int(8) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `code` varchar(255) NOT NULL,
    `image` text NOT NULL,
    `price` double(10,2) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_code` (`code`)
);

INSERT INTO `product` (`id`, `name`, `code`, `image`, `price`) VALUES 
    (1, 'Smart Bulb', 'LB130', 'product-images/bulb.jpg', 40),
    (2, 'Fiftyeight Bowl', 'T010623', 'product-images/bowl.jpg', 30),
    (3, 'Watch Me Wall Clock', '341015', 'product-images/clock.jpg', 45);

CREATE TABLE `customers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone` varchar(15) NOT NULL,
    `address` text NOT NULL,
    `status` enum('1','0') NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
);

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `status`) VALUES 
    ('1', 'test_user', 'test@mail.com', '0123456789', 'Testlaan 123\r\n1234ab\r\nTestCity', '1');

CREATE TABLE `orders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(11) NOT NULL,
    `total_price` float(10,2) NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    `status` enum('1','0') NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    KEY `customer_id` (`customer_id`),
    CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE `order_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `order_id` int(11) NOT NULL,
    `product_code` varchar(255) NOT NULL,
    `quantity` int(5) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `order_id` (`order_id`),
    CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);