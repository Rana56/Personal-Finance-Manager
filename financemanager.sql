-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2023 at 11:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `financemanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `budgetID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`budgetID`, `userID`, `categoryID`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(3, 1, 6, '33.00', 'ohhh', '2023-04-10 03:14:21', '2023-04-10 03:14:21'),
(5, 1, 5, '34.00', 'Test', '2023-04-10 21:30:49', '2023-04-10 21:30:49'),
(12, 1, 1, '20.00', 'Test', '2023-04-10 21:40:45', '2023-04-10 21:40:45'),
(13, 1, 12, '50.00', 'Test', '2023-04-10 21:41:23', '2023-04-10 21:41:23'),
(14, 1, 3, '10.00', 'Bus', '2023-04-10 21:42:37', '2023-04-10 21:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `categoryName` text NOT NULL,
  `icon` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`, `icon`) VALUES
(1, 'Groceries', 'local_grocery_store'),
(2, 'Rent', 'key'),
(3, 'Transportation', 'commute'),
(4, 'Utilities', 'cottage'),
(5, 'Entertainment', 'local_activity'),
(6, 'Eating Out', 'dining'),
(7, 'Travel', 'flight'),
(8, 'Health Care', 'medical_information'),
(9, 'Shopping', 'shopping_cart'),
(10, 'Other', 'blur_on'),
(11, 'Salary', 'account_balance'),
(12, 'Payment', 'sell'),
(13, 'Investments', 'auto_awesome');

-- --------------------------------------------------------

--
-- Table structure for table `encouragement`
--

CREATE TABLE `encouragement` (
  `encourageID` int(11) NOT NULL,
  `sentence` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `encouragement`
--

INSERT INTO `encouragement` (`encourageID`, `sentence`) VALUES
(1, '“Believe in yourself\"'),
(2, '“You\'ve got this!\"'),
(3, '\"Keep Saving!\"'),
(4, '\"Focus on the journey, not the destination\"'),
(5, 'Remember to have a look at our savings page for tips & tricks!'),
(6, '\"Believe in yourself\"'),
(7, '“Success only comes to those who dare to attempt”'),
(8, '\"It always seems impossible until it\'s done\"'),
(9, '\"If you can dream it, you can do it\"'),
(10, '\"Don\'t Give Up\"');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expenseID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expenseID`, `userID`, `categoryID`, `amount`, `date`, `note`) VALUES
(1, 1, 3, '12.00', '2023-04-01', 'Bus'),
(2, 1, 8, '30.65', '2023-04-06', 'Boots'),
(3, 1, 13, '30.65', '2023-04-12', 'Tesco'),
(4, 1, 12, '17.38', '2023-04-05', 'expense test'),
(5, 1, 8, '17.38', '2023-04-01', 'test'),
(6, 1, 11, '30.65', '2023-04-08', 'expense test'),
(7, 1, 6, '12.56', '2023-04-06', 'expense test'),
(10, 1, 6, '30.65', '2023-04-13', 'expense test'),
(11, 1, 6, '17.38', '2023-04-07', 'KFC'),
(12, 1, 6, '100.00', '2023-03-09', 'KFC'),
(13, 1, 5, '40.00', '2023-04-19', 'party');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `goal_ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `goalName` varchar(256) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`goal_ID`, `userID`, `goalName`, `note`) VALUES
(2, 1, 'Testing goals', 'wow is this testing'),
(3, 1, 'This is goals ', 'Damn');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `incomeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`incomeID`, `userID`, `categoryID`, `amount`, `date`, `note`) VALUES
(1, 1, 11, '20.00', '2023-04-05', 'Testing '),
(5, 1, 10, '13.56', '2023-04-11', 'income'),
(6, 1, 6, '13.56', '2023-04-08', 'select'),
(11, 1, 4, '25.00', '2023-03-01', 'Testing '),
(12, 1, 6, '13.23', '2023-04-20', 'income'),
(13, 1, 10, '25.56', '2023-04-04', 'Gift'),
(14, 1, 10, '13.56', '2023-04-09', 'Gift'),
(15, 1, 11, '13.23', '2023-04-04', 'Testing '),
(16, 1, 11, '100.00', '2023-03-08', 'income'),
(17, 1, 10, '13.23', '2023-04-04', 'Gift'),
(18, 1, 6, '30.00', '2023-03-21', 'Testing '),
(19, 1, 6, '30.00', '2023-04-09', 'Gift');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `webID` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `link` text NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`webID`, `title`, `text`, `link`, `image`) VALUES
(1, 'Personal Finance Basics', 'Here\'s a good source to explore to get you up to speed about the basics of personal finance.\r\nIt provides good explanations of definitions and budgeting.', 'https://www.investopedia.com/personal-finance-4427760', 'placeholder.png'),
(2, 'Manage your money with budgeting', 'Have a look at the benefits with budgeting and delve into the various techniques with spreadsheets or apps!', 'https://www.moneysavingexpert.com/banking/budget-planning/', 'placeholder.png'),
(3, 'Tips to reduce your cost of living', 'Utilise the available tips to help save you money during this cost of living crisis. ', 'https://ben.org.uk/how-we-help/for-me/articles/reduce-your-living-costs/', 'placeholder.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(256) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`) VALUES
(1, 'na200@yahoo.co.uk', '$2y$10$IjhqO/XQhW15NmZ0e84tMej03tpeTpVP18541UNoGZ7wM2M2APJGq', 'hi', 'rn'),
(2, 'na@gmail.com', '$2y$10$NUOhGxU3twDw8obSidskqung02eEuqTWoH2xl7GvGJllGG0PeOFgG', 'a', 'b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`budgetID`),
  ADD KEY `category Budget` (`categoryID`),
  ADD KEY `User Foreign` (`userID`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `encouragement`
--
ALTER TABLE `encouragement`
  ADD PRIMARY KEY (`encourageID`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expenseID`),
  ADD KEY `userExpense` (`userID`),
  ADD KEY `categoryExpense` (`categoryID`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`goal_ID`),
  ADD KEY `userGoal` (`userID`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`incomeID`),
  ADD KEY `userIncome` (`userID`),
  ADD KEY `categoryIncome` (`categoryID`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`webID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `budgetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `encouragement`
--
ALTER TABLE `encouragement`
  MODIFY `encourageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `goal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `incomeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `webID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `User Foreign` FOREIGN KEY (`userID`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `category Budget` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `categoryExpense` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`),
  ADD CONSTRAINT `userExpense` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `userGoal` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `categoryIncome` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`),
  ADD CONSTRAINT `userIncome` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
