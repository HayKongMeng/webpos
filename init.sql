-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 07:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_mart`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Drink'),
(3, 'Electronic'),
(2, 'Food');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `CustomerAddress` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `ContactNumber`, `Email`, `CustomerName`, `CustomerAddress`) VALUES
(1, '01234567', 'sok.van.1221@rupp.edu.kh', 'Sunly Menghak', 'Phnom Penh'),
(2, '070641776', 'menghaksl999@gmail.com', 'Sok Van', 'Phnom Penh'),
(5, '070641776', 'sok.van.1221@rupp.edu.kh', 'Sok Van', 'Phnom Penh'),
(6, '01234567', 'sok.van.1221@rupp.edu.kh', 'Sok Van', 'Phnom Penh'),
(7, '070641776', 'sok.van.1221@rupp.edu.kh', 'Sok Van', 'Phnom Penh');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `SaleID` int(11) DEFAULT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PaymentMethod` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `SaleID`, `PaymentDate`, `PaymentMethod`, `Amount`) VALUES
(1, 1, '2025-03-21 17:53:22', 'cash', 89.00),
(2, 2, '2025-03-21 18:10:38', 'cash', 20.00),
(3, 4, '2025-03-21 19:03:37', 'credit_card', 110.00),
(4, 5, '2025-03-23 14:50:14', 'credit_card', 100.00),
(5, 6, '2025-03-23 15:48:43', 'credit_card', 25.00),
(6, 7, '2025-03-23 15:49:34', 'debit_card', 100.00),
(7, 8, '2025-03-23 15:50:42', 'cash', 3.00),
(8, 9, '2025-03-23 15:52:53', 'credit_card', 50.00),
(9, 10, '2025-03-23 16:12:29', 'credit_card', 50.00),
(10, 11, '2025-03-23 16:13:26', 'credit_card', 100.00),
(11, 12, '2025-03-23 16:19:39', 'credit_card', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `StockQuantity` int(11) NOT NULL DEFAULT 0,
  `product_image` varchar(255) DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `CategoryID`, `Price`, `StockQuantity`, `product_image`, `add_date`) VALUES
(1, 'Light', 3, 10.00, 82, 'uploads/products/67dbab2718a7b.jpg', '2025-03-20 23:37:18'),
(2, 'Hamburger', 2, 5.00, 10, 'uploads/products/67dbd02524a61.jpg', '2025-03-20 23:37:18'),
(3, 'Network Cable', 3, 3.00, 15, 'uploads/products/67dc0752465a0.jpg', '2025-03-20 23:37:18'),
(4, 'Electric Cable', 3, 20.00, 28, 'uploads/products/67dc4a468206e.jpg', '2025-03-21 00:03:02'),
(5, 'Cake', 2, 3.00, 4, 'uploads/products/67dc4a925914d.jpg', '2025-03-21 00:04:18'),
(6, 'Sea Food', 2, 10.80, 5, 'uploads/products/67de9b7078884.jpg', '2025-03-22 18:13:52'),
(7, 'Hot Dog', 2, 5.00, 5, 'uploads/products/67e1086f877bf.jpg', '2025-03-24 14:23:27'),
(8, 'Noodel', 2, 2.00, 20, 'uploads/products/67e13b9e3f6df.jpg', '2025-03-24 18:01:50'),
(9, 'Avocado', 1, 4.00, 10, 'uploads/products/67e13cba6ff37.jpg', '2025-03-24 18:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `saleitems`
--

CREATE TABLE `saleitems` (
  `SaleItemID` int(11) NOT NULL,
  `SaleID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `PricePerUnit` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saleitems`
--

INSERT INTO `saleitems` (`SaleItemID`, `SaleID`, `ProductID`, `Quantity`, `PricePerUnit`, `Subtotal`) VALUES
(1, 1, 4, 4, 20.00, 80.00),
(2, 1, 5, 3, 3.00, 9.00),
(3, 2, 1, 2, 10.00, 20.00),
(5, 4, 4, 3, 20.00, 60.00),
(6, 4, 3, 5, 3.00, 15.00),
(7, 4, 1, 1, 10.00, 10.00),
(8, 4, 2, 5, 5.00, 25.00),
(9, 5, 4, 5, 20.00, 100.00),
(10, 6, 2, 5, 5.00, 25.00),
(11, 7, 4, 5, 20.00, 100.00),
(12, 8, 5, 1, 3.00, 3.00),
(13, 9, 1, 5, 10.00, 50.00),
(14, 10, 1, 5, 10.00, 50.00),
(15, 11, 4, 5, 20.00, 100.00),
(16, 12, 5, 5, 3.00, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `SaleID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SaleDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TotalAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`SaleID`, `CustomerID`, `UserID`, `SaleDate`, `TotalAmount`) VALUES
(1, 1, NULL, '2025-03-21 17:53:22', 89.00),
(2, NULL, NULL, '2025-03-21 18:10:38', 20.00),
(4, 1, NULL, '2025-03-21 19:03:37', 110.00),
(5, NULL, NULL, '2025-03-23 14:50:14', 100.00),
(6, 2, NULL, '2025-03-23 15:48:43', 25.00),
(7, 1, NULL, '2025-03-23 15:49:34', 100.00),
(8, 2, NULL, '2025-03-23 15:50:42', 3.00),
(9, 2, NULL, '2025-03-23 15:52:53', 50.00),
(10, 5, NULL, '2025-03-23 16:12:29', 50.00),
(11, 6, NULL, '2025-03-23 16:13:26', 100.00),
(12, 7, NULL, '2025-03-23 16:19:39', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Role`) VALUES
(1, 'admin', '$2y$10$J6A7t9x2gxKKEVIbm1D8n..P2uTXi.5yPoPiZgXxlhrHjuXzFXIBK', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`),
  ADD UNIQUE KEY `CategoryName` (`CategoryName`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `SaleID` (`SaleID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `saleitems`
--
ALTER TABLE `saleitems`
  ADD PRIMARY KEY (`SaleItemID`),
  ADD KEY `SaleID` (`SaleID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`SaleID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `saleitems`
--
ALTER TABLE `saleitems`
  MODIFY `SaleItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `SaleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`SaleID`) REFERENCES `sales` (`SaleID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`);

--
-- Constraints for table `saleitems`
--
ALTER TABLE `saleitems`
  ADD CONSTRAINT `saleitems_ibfk_1` FOREIGN KEY (`SaleID`) REFERENCES `sales` (`SaleID`),
  ADD CONSTRAINT `saleitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
