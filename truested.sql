-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2023 at 10:02 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truested`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-12-20-081039', 'App\\Database\\Migrations\\Categories', 'default', 'App', 1642051752, 1),
(2, '2021-12-21-073405', 'App\\Database\\Migrations\\TblAdmin', 'default', 'App', 1642051752, 1),
(3, '2021-12-22-101127', 'App\\Database\\Migrations\\Users', 'default', 'App', 1642051752, 1),
(4, '2021-12-22-102735', 'App\\Database\\Migrations\\Media', 'default', 'App', 1642051752, 1),
(5, '2021-12-28-063758', 'App\\Database\\Migrations\\DeletedTable', 'default', 'App', 1642051752, 1),
(6, '2021-12-28-121356', 'App\\Database\\Migrations\\AddFieldsToTblCategories', 'default', 'App', 1642051752, 1),
(7, '2022-01-05-122805', 'App\\Database\\Migrations\\CreateSettingsTable', 'default', 'App', 1642051752, 1),
(8, '2022-01-12-095813', 'App\\Database\\Migrations\\CreateCountriesTable', 'default', 'App', 1642051752, 1),
(9, '2022-01-12-104234', 'App\\Database\\Migrations\\ProductsTable', 'default', 'App', 1642051752, 1),
(11, '2022-01-13-072401', 'App\\Database\\Migrations\\AddFieldsToTblUsers', 'default', 'App', 1642058680, 2),
(12, '2022-01-13-095134', 'App\\Database\\Migrations\\CreateTblDocuments', 'default', 'App', 1642068677, 3),
(15, '2022-01-17-061817', 'App\\Database\\Migrations\\Createnewfieldcatgory', 'default', 'App', 1642400752, 5),
(16, '2022-01-17-073000', 'App\\Database\\Migrations\\Addfieldtouserstable', 'default', 'App', 1642404822, 6),
(17, '2022-01-17-144838', 'App\\Database\\Migrations\\MembershipTable', 'default', 'App', 1642431336, 7),
(24, '2022-01-12-122955', 'App\\Database\\Migrations\\StocksTable', 'default', 'App', 1642439519, 8),
(25, '2022-01-13-054429', 'App\\Database\\Migrations\\AddFieldsToTblStocks', 'default', 'App', 1642439519, 8),
(26, '2022-01-19-062225', 'App\\Database\\Migrations\\AddFieldsToProducts', 'default', 'App', 1642743543, 9),
(27, '2022-01-21-053355', 'App\\Database\\Migrations\\AddFieldsToTblProducts', 'default', 'App', 1642743543, 9),
(28, '2022-01-21-062959', 'App\\Database\\Migrations\\AddRetailValueFieldToTblProducts', 'default', 'App', 1642747303, 10),
(29, '2022-01-25-062322', 'App\\Database\\Migrations\\Addmemberamountfieldtostocktable', 'default', 'App', 1643094569, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `name`, `email`, `password`, `status`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'Nexus Techies', 'provider.nexus@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1', NULL, '2021-12-22 11:49:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `slug` varchar(255) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `parent_id`, `title`, `description`, `status`, `slug`, `media_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'Bathroom Installation', 'Celebrity is a condition of fame and broad public recognition of an individual or group as a result of the attention given to them by mass media.', '1', 'bathroom-installation-1', 78, '2021-12-22 17:44:16', NULL, NULL),
(2, 0, 'Blacksmith / Metal worker', 'An entrepreneur is an individual who creates a new business, bearing most of the risks and enjoying most of the rewards.', '0', 'blacksmith-metal-worker-2', 0, '2021-12-22 17:44:47', NULL, NULL),
(3, 0, 'Bricklaying', '', '1', 'bricklaying-3', 0, '2022-01-04 07:34:57', NULL, NULL),
(4, 0, 'Building Construction', '', '1', 'building-construction-4', 0, '2022-01-06 07:31:31', NULL, NULL),
(5, 1, ' Bathroom Remodeling and Renovation', '', '1', '-bathroom-remodeling-and-renovation-5', 0, '2022-01-06 07:38:50', NULL, NULL),
(6, 1, 'Bathtub Refinishing', 'adsxca', '1', 'bathtub-refinishing-6', 43, '2022-01-17 12:13:05', NULL, NULL),
(7, 1, 'Bathroom Planning and Design', 'Qwaedx', '1', 'bathroom-planning-and-design-7', 45, '2022-01-17 12:13:57', NULL, NULL),
(9, 3, ' Chimney Building and Repairs', 'Chimney Building / Repair', '1', '-chimney-building-and-repairs-9', 0, '2022-06-04 12:19:01', NULL, NULL),
(11, 0, 'Gardening and Landscaping', '', '1', 'gardening-and-landscaping-11', 0, '2022-06-08 05:13:09', NULL, NULL),
(12, 11, 'Artificial Grass and Turf', '', '1', 'artificial-grass-and-turf-12', 0, '2022-06-08 05:13:43', NULL, NULL),
(13, 1, 'Bathroom Maintenance and Repairs', '', '1', 'bathroom-maintenance-and-repairs-13', 0, '2022-06-08 05:36:26', NULL, NULL),
(14, 1, ' Bathroom Tiling and Mosaics', '', '1', '-bathroom-tiling-and-mosaics-14', 0, '2022-06-08 05:44:48', NULL, NULL),
(15, 1, ' Full Bathroom Overhaul and Renovation', '', '1', '-full-bathroom-overhaul-and-renovation-15', 0, '2022-06-08 05:45:07', NULL, NULL),
(16, 1, ' Wet Room Construction and Installation', '', '1', '-wet-room-construction-and-installation-16', 0, '2022-06-08 05:45:21', NULL, NULL),
(17, 2, 'Decorative Ironmongery and Metalwork', '', '1', 'decorative-ironmongery-and-metalwork-17', 0, '2022-06-08 05:46:24', NULL, NULL),
(18, 2, 'Metal Kitchen Worktops', '', '1', 'metal-kitchen-worktops-18', 0, '2022-06-08 05:46:52', NULL, NULL),
(19, 2, 'Security Fencing', '', '1', 'security-fencing-19', 0, '2022-06-08 05:49:03', NULL, NULL),
(20, 2, 'Security Gates & Bollard', '', '1', 'security-gates-and-bollard-20', 0, '2022-06-08 05:49:43', NULL, NULL),
(21, 2, 'Security Fencing', '', '1', 'security-fencing-21', 0, '2022-06-08 05:52:50', NULL, NULL),
(22, 2, 'Security Grill', '', '1', 'security-grill-22', 0, '2022-06-08 05:53:56', NULL, NULL),
(23, 2, 'Wooden / Metal / Wire Fences', '', '1', 'wooden-metal-wire-fences-23', 0, '2022-06-08 05:54:19', NULL, NULL),
(24, 0, 'Loft Conversion', '', '1', 'loft-conversion-24', 0, '2022-06-08 05:54:22', NULL, NULL),
(25, 2, 'Zinc / Metal Roof', '', '1', 'zinc-metal-roof-25', 0, '2022-06-08 05:54:42', NULL, NULL),
(26, 24, 'Home Renovations and Improvements', '', '1', 'home-renovations-and-improvements-26', 0, '2022-06-08 05:56:02', NULL, NULL),
(27, 3, 'Garden Walls and Retaining Walls', '', '1', 'garden-walls-and-retaining-walls-27', 0, '2022-06-08 05:56:31', NULL, NULL),
(28, 24, 'Loft Conversions and Attic Renovations', '', '1', 'loft-conversions-and-attic-renovations-28', 0, '2022-06-08 05:56:37', NULL, NULL),
(29, 24, 'Staircase Installation (Metal and Wood)', '', '1', 'staircase-installation-metal-and-wood-29', 0, '2022-06-08 05:56:48', NULL, NULL),
(30, 3, 'Outdoor Pizza Ovens and Grills', '', '1', 'outdoor-pizza-ovens-and-grills-30', 0, '2022-06-08 05:56:57', NULL, NULL),
(31, 24, 'Skylight and Roof Window Installation', '', '1', 'skylight-and-roof-window-installation-31', 0, '2022-06-08 05:56:59', NULL, NULL),
(32, 3, 'Tuckpointing and Repointing', '', '1', 'tuckpointing-and-repointing-32', 0, '2022-06-08 05:57:21', NULL, NULL),
(33, 24, 'Additional Storage Solutions', '', '1', 'additional-storage-solutions-33', 0, '2022-06-08 05:57:23', NULL, NULL),
(34, 0, 'Painting and Decorating', '', '1', 'painting-and-decorating-34', 0, '2022-06-08 05:58:19', NULL, NULL),
(35, 34, 'Wall Murals and Decorative Painting', '', '1', 'wall-murals-and-decorative-painting-35', 0, '2022-06-08 05:58:34', NULL, NULL),
(36, 34, 'Protective Coatings', '', '1', 'protective-coatings-36', 0, '2022-06-08 05:58:46', NULL, NULL),
(37, 34, 'Plastering and Drywall', '', '1', 'plastering-and-drywall-37', 0, '2022-06-08 05:58:58', NULL, NULL),
(38, 34, 'Staining and Varnishing', '', '1', 'staining-and-varnishing-38', 0, '2022-06-08 05:59:10', NULL, NULL),
(39, 34, 'Coving and Cornicing', '', '1', 'coving-and-cornicing-39', 0, '2022-06-08 05:59:22', NULL, NULL),
(40, 3, ' Stone Cladding and Stonework', '', '1', '-stone-cladding-and-stonework-40', 0, '2022-06-08 05:59:27', NULL, NULL),
(41, 0, 'Pest Management', '', '1', 'pest-management-41', 0, '2022-06-08 06:00:58', NULL, NULL),
(42, 41, 'Professional Commercial Pest Management', '', '1', 'professional-commercial-pest-management-42', 0, '2022-06-08 06:01:18', NULL, NULL),
(43, 41, 'Professional Residential Pest Management', '', '1', 'professional-residential-pest-management-43', 0, '2022-06-08 06:01:30', NULL, NULL),
(44, 0, 'Plastering and Rendering', '', '1', 'plastering-and-rendering-44', 0, '2022-06-08 06:02:05', NULL, NULL),
(45, 44, 'Decorative Plaster and Molding Work', '', '1', 'decorative-plaster-and-molding-work-45', 0, '2022-06-08 06:02:27', NULL, NULL),
(46, 44, 'Drywall Installation and Repair Services', '', '1', 'drywall-installation-and-repair-services-46', 0, '2022-06-08 06:02:42', NULL, NULL),
(47, 44, 'External and Internal Wall Finishing', '', '1', 'external-and-internal-wall-finishing-47', 0, '2022-06-08 06:02:57', NULL, NULL),
(48, 44, 'External Insulation Solutions', '', '1', 'external-insulation-solutions-48', 0, '2022-06-08 06:03:12', NULL, NULL),
(49, 44, 'Textured Finishes (such as pebble-dashing)', '', '1', 'textured-finishes-such-as-pebble-dashing-49', 0, '2022-06-08 06:03:30', NULL, NULL),
(50, 44, 'Skimming and Smoothing Services', '', '1', 'skimming-and-smoothing-services-50', 0, '2022-06-08 06:03:44', NULL, NULL),
(51, 44, 'Specialty Plaster Finishes (such as polished plaster)', '', '1', 'specialty-plaster-finishes-such-as-polished-plaster-51', 0, '2022-06-08 06:04:00', NULL, NULL),
(52, 44, 'Floor Leveling and Screeding', '', '1', 'floor-leveling-and-screeding-52', 0, '2022-06-08 06:04:12', NULL, NULL),
(53, 44, 'Cornice and Coving installation', '', '1', 'cornice-and-coving-installation-53', 0, '2022-06-08 06:04:23', NULL, NULL),
(54, 44, 'Screeding', '', '1', 'screeding-54', 0, '2022-06-08 06:04:37', NULL, NULL),
(55, 44, 'Standard Coving', '', '1', 'standard-coving-55', 0, '2022-06-08 06:04:50', NULL, NULL),
(56, 0, 'Plumbing', '', '1', 'plumbing-56', 0, '2022-06-08 06:05:29', NULL, NULL),
(57, 56, 'Bathroom and Kitchen Plumbing Solutions', '', '1', 'bathroom-and-kitchen-plumbing-solutions-57', 0, '2022-06-08 06:05:44', NULL, NULL),
(58, 56, 'Emergency Plumbing Assistance', '', '1', 'emergency-plumbing-assistance-58', 0, '2022-06-08 06:05:56', NULL, NULL),
(59, 56, 'Gutter and Drainage System Solutions', '', '1', 'gutter-and-drainage-system-solutions-59', 0, '2022-06-08 06:06:07', NULL, NULL),
(60, 56, 'Hot tub, spa and pool plumbing', '', '1', 'hot-tub-spa-and-pool-plumbing-60', 0, '2022-06-08 06:06:17', NULL, NULL),
(61, 4, 'Insulation for Cavity Walls', '', '1', 'insulation-for-cavity-walls-61', 0, '2022-06-08 06:06:25', NULL, NULL),
(62, 56, 'Plumbing Maintenance and Repairs', '', '1', 'plumbing-maintenance-and-repairs-62', 0, '2022-06-08 06:06:28', NULL, NULL),
(63, 56, 'Heating and Gas Repairs and Installations', '', '1', 'heating-and-gas-repairs-and-installations-63', 0, '2022-06-08 06:06:38', NULL, NULL),
(64, 56, 'Solar Water and Heating Systems', '', '1', 'solar-water-and-heating-systems-64', 0, '2022-06-08 06:06:50', NULL, NULL),
(65, 56, 'Irrigation and Sprinkler Systems', '', '1', 'irrigation-and-sprinkler-systems-65', 0, '2022-06-08 06:07:03', NULL, NULL),
(66, 56, 'Water tank and Boiler Repairs and Installations', '', '1', 'water-tank-and-boiler-repairs-and-installations-66', 0, '2022-06-08 06:07:14', NULL, NULL),
(67, 4, ' Basement and Cellar Conversions', '', '1', '-basement-and-cellar-conversions-67', 0, '2022-06-08 06:07:18', NULL, NULL),
(68, 56, 'Underfloor Heating Systems', '', '1', 'underfloor-heating-systems-68', 0, '2022-06-08 06:07:26', NULL, NULL),
(69, 56, 'Water Tanks and Immersion Heater', '', '1', 'water-tanks-and-immersion-heater-69', 0, '2022-06-08 06:07:36', NULL, NULL),
(70, 56, 'Water Underfloor Heating', '', '1', 'water-underfloor-heating-70', 0, '2022-06-08 06:07:47', NULL, NULL),
(71, 0, 'Moving and Removals', '', '1', 'moving-and-removals-71', 0, '2022-06-08 06:08:10', NULL, NULL),
(72, 71, 'Professional Moving and Packing', '', '1', 'professional-moving-and-packing-72', 0, '2022-06-08 06:08:30', NULL, NULL),
(73, 71, 'Residential and Commercial Moving', '', '1', 'residential-and-commercial-moving-73', 0, '2022-06-08 06:08:42', NULL, NULL),
(74, 71, 'Man with a Van Services', '', '1', 'man-with-a-van-services-74', 0, '2022-06-08 06:08:53', NULL, NULL),
(75, 71, 'Specialty Item Moving and Shipping', '', '1', 'specialty-item-moving-and-shipping-75', 0, '2022-06-08 06:09:03', NULL, NULL),
(76, 71, 'Climate Controlled Storage', '', '1', 'climate-controlled-storage-76', 0, '2022-06-08 06:09:14', NULL, NULL),
(77, 71, 'Waste and Junk Removal', '', '1', 'waste-and-junk-removal-77', 0, '2022-06-08 06:09:25', NULL, NULL),
(78, 4, 'Chimney Building and Repairs', '', '1', 'chimney-building-and-repairs-78', 0, '2022-06-08 06:09:45', NULL, NULL),
(79, 0, 'Roofing', '', '1', 'roofing-79', 0, '2022-06-08 06:09:54', NULL, NULL),
(80, 4, 'Cladding and Siding', '', '1', 'cladding-and-siding-80', 0, '2022-06-08 06:10:13', NULL, NULL),
(81, 4, 'Conservatory and Sunroom Construction', '', '1', 'conservatory-and-sunroom-construction-81', 0, '2022-06-08 06:10:40', NULL, NULL),
(82, 79, 'Roof Repair and Maintenance', '', '1', 'roof-repair-and-maintenance-82', 0, '2022-06-08 06:10:52', NULL, NULL),
(83, 79, 'Flat Roofing', '', '1', 'flat-roofing-83', 0, '2022-06-08 06:11:03', NULL, NULL),
(84, 4, ' Handicap Accessibility Upgrades', '', '1', '-handicap-accessibility-upgrades-84', 0, '2022-06-08 06:11:09', NULL, NULL),
(85, 79, 'Asbestos Roofing and Removal', '', '1', 'asbestos-roofing-and-removal-85', 0, '2022-06-08 06:11:14', NULL, NULL),
(86, 79, 'Leadwork', '', '1', 'leadwork-86', 0, '2022-06-08 06:11:24', NULL, NULL),
(87, 4, 'Garage Conversions', '', '1', 'garage-conversions-87', 0, '2022-06-08 06:11:30', NULL, NULL),
(88, 79, 'Guttering and Drainage', '', '1', 'guttering-and-drainage-88', 0, '2022-06-08 06:11:34', NULL, NULL),
(89, 79, 'Chimney Repairs', '', '1', 'chimney-repairs-89', 0, '2022-06-08 06:11:45', NULL, NULL),
(90, 4, 'Garden Office and Studio Building', '', '1', 'garden-office-and-studio-building-90', 0, '2022-06-08 06:11:54', NULL, NULL),
(91, 79, 'Skylight Installation', '', '1', 'skylight-installation-91', 0, '2022-06-08 06:11:56', NULL, NULL),
(92, 79, 'Roof Insulation', '', '1', 'roof-insulation-92', 0, '2022-06-08 06:12:08', NULL, NULL),
(93, 79, 'Roofing for Historical and Listed Buildings', '', '1', 'roofing-for-historical-and-listed-buildings-93', 0, '2022-06-08 06:12:19', NULL, NULL),
(94, 4, 'Site Preparation and Foundation Work', '', '1', 'site-preparation-and-foundation-work-94', 0, '2022-06-08 06:12:22', NULL, NULL),
(95, 79, 'Roofing for Outbuildings and Garden Structures', '', '1', 'roofing-for-outbuildings-and-garden-structures-95', 0, '2022-06-08 06:12:32', NULL, NULL),
(96, 79, 'Tiling and Slating', '', '1', 'tiling-and-slating-96', 0, '2022-06-08 06:12:43', NULL, NULL),
(97, 4, 'Home Renovations and Additions', '', '1', 'home-renovations-and-additions-97', 0, '2022-06-08 06:12:49', NULL, NULL),
(98, 79, 'Zinc and Copper Roofing', '', '1', 'zinc-and-copper-roofing-98', 0, '2022-06-08 06:12:53', NULL, NULL),
(99, 0, 'Security Systems and Alarms', '', '1', 'security-systems-and-alarms-99', 0, '2022-06-08 06:13:12', NULL, NULL),
(100, 4, 'House Additions', '', '1', 'house-additions-100', 0, '2022-06-08 06:13:18', NULL, NULL),
(101, 99, 'Access Control / Door Entry', '', '1', 'access-control-door-entry-101', 0, '2022-06-08 06:13:31', NULL, NULL),
(102, 4, 'Loft Conversions', '', '1', 'loft-conversions-102', 0, '2022-06-08 06:13:42', NULL, NULL),
(103, 99, 'Burglar, Security & Intruder Alarm Installation', '', '1', 'burglar-security-and-intruder-alarm-installation-103', 0, '2022-06-08 06:13:43', NULL, NULL),
(104, 99, 'CCTV Installation', '', '1', 'cctv-installation-104', 0, '2022-06-08 06:13:54', NULL, NULL),
(105, 99, 'Fire Alarm Installation', '', '1', 'fire-alarm-installation-105', 0, '2022-06-08 06:14:04', NULL, NULL),
(106, 4, 'Timber-Framed Building and Log Cabins', '', '1', 'timber-framed-building-and-log-cabins-106', 0, '2022-06-08 06:14:07', NULL, NULL),
(107, 99, 'Garage Doors - Installation / Repair', '', '1', 'garage-doors---installation-repair-107', 0, '2022-06-08 06:14:16', NULL, NULL),
(108, 4, 'Metal Staircases', '', '1', 'metal-staircases-108', 0, '2022-06-08 06:14:26', NULL, NULL),
(109, 99, 'Lock Fitting / Repair', '', '1', 'lock-fitting-repair-109', 0, '2022-06-08 06:14:26', NULL, NULL),
(110, 99, 'Roller Shutters - Installation / Repair', '', '1', 'roller-shutters---installation-repair-110', 0, '2022-06-08 06:14:36', NULL, NULL),
(111, 99, 'Security Fencing', '', '1', 'security-fencing-111', 0, '2022-06-08 06:14:46', NULL, NULL),
(112, 4, 'Mold and Damp Control', '', '1', 'mold-and-damp-control-112', 0, '2022-06-08 06:14:51', NULL, NULL),
(113, 99, 'Security Gates & Bollard', '', '1', 'security-gates-and-bollard-113', 0, '2022-06-08 06:15:03', NULL, NULL),
(114, 4, 'Partition Walls', '', '1', 'partition-walls-114', 0, '2022-06-08 06:15:14', NULL, NULL),
(115, 4, 'Restoration for Historic and Listed Buildings', '', '1', 'restoration-for-historic-and-listed-buildings-115', 0, '2022-06-08 06:15:35', NULL, NULL),
(116, 99, 'Security Grill', '', '1', 'security-grill-116', 0, '2022-06-08 06:15:35', NULL, NULL),
(117, 4, 'Outdoor Pizza Ovens', '', '1', 'outdoor-pizza-ovens-117', 0, '2022-06-08 06:15:59', NULL, NULL),
(118, 0, 'Specialist Tradesperson', '', '0', 'specialist-tradesperson-118', 0, '2022-06-08 06:16:07', NULL, NULL),
(119, 118, 'Aerial & Satellite Dish Installation', '', '1', 'aerial-and-satellite-dish-installation-119', 0, '2022-06-08 06:16:33', NULL, NULL),
(120, 4, 'Porches and Canopies', '', '1', 'porches-and-canopies-120', 0, '2022-06-08 06:16:37', NULL, NULL),
(121, 118, 'Air Conditioning / Refrigeration', '', '1', 'air-conditioning-refrigeration-121', 0, '2022-06-08 06:16:46', NULL, NULL),
(122, 118, 'Brick / Block Paving', '', '1', 'brick-block-paving-122', 0, '2022-06-08 06:17:00', NULL, NULL),
(123, 4, 'Post-Construction Cleaning', '', '1', 'post-construction-cleaning-123', 0, '2022-06-08 06:17:04', NULL, NULL),
(124, 118, 'Brick & Stone Cleaning', '', '1', 'brick-and-stone-cleaning-124', 0, '2022-06-08 06:17:11', NULL, NULL),
(125, 4, 'Steel Fabrication and Structural Steelwork', '', '1', 'steel-fabrication-and-structural-steelwork-125', 0, '2022-06-08 06:17:28', NULL, NULL),
(126, 118, 'Cellar & Basement Conversion', '', '1', 'cellar-and-basement-conversion-126', 0, '2022-06-08 06:17:28', NULL, NULL),
(127, 118, 'Damp Proofing', '', '1', 'damp-proofing-127', 0, '2022-06-08 06:17:40', NULL, NULL),
(128, 118, 'Demolition', '', '1', 'demolition-128', 0, '2022-06-08 06:17:50', NULL, NULL),
(129, 4, 'Suspended Ceilings', '', '1', 'suspended-ceilings-129', 0, '2022-06-08 06:17:55', NULL, NULL),
(130, 118, 'Digital Home Network', '', '1', 'digital-home-network-130', 0, '2022-06-08 06:18:01', NULL, NULL),
(131, 118, 'Disabled Access / Mobility Service', '', '1', 'disabled-access-mobility-service-131', 0, '2022-06-08 06:18:13', NULL, NULL),
(132, 4, 'Underfloor Insulation', '', '1', 'underfloor-insulation-132', 0, '2022-06-08 06:18:18', NULL, NULL),
(133, 118, 'Fireplace', '', '1', 'fireplace-133', 0, '2022-06-08 06:18:24', NULL, NULL),
(134, 118, 'Scaffolding', '', '1', 'scaffolding-134', 0, '2022-06-08 06:18:37', NULL, NULL),
(135, 4, 'Foundation Reinforcement and Piling', '', '1', 'foundation-reinforcement-and-piling-135', 0, '2022-06-08 06:18:45', NULL, NULL),
(136, 118, 'Sound & Audio Visual Installation', '', '1', 'sound-and-audio-visual-installation-136', 0, '2022-06-08 06:18:47', NULL, NULL),
(137, 118, 'Sound Proofing', '', '1', 'sound-proofing-137', 0, '2022-06-08 06:18:59', NULL, NULL),
(138, 4, 'Wooden Staircases and Railings', '', '1', 'wooden-staircases-and-railings-138', 0, '2022-06-08 06:19:06', NULL, NULL),
(139, 118, 'Stored Gas', '', '1', 'stored-gas-139', 0, '2022-06-08 06:19:14', NULL, NULL),
(140, 118, 'Stored Oil', '', '1', 'stored-oil-140', 0, '2022-06-08 06:19:28', NULL, NULL),
(141, 118, 'Thermal Insulation', '', '1', 'thermal-insulation-141', 0, '2022-06-08 06:19:38', NULL, NULL),
(142, 118, 'Timber Preservation, Woodworm & Rot', '', '1', 'timber-preservation-woodworm-and-rot-142', 0, '2022-06-08 06:19:53', NULL, NULL),
(143, 118, 'Waste Removal', '', '1', 'waste-removal-143', 0, '2022-06-08 06:20:04', NULL, NULL),
(144, 118, 'Water Underfloor Heating', '', '1', 'water-underfloor-heating-144', 0, '2022-06-08 06:20:16', NULL, NULL),
(145, 118, 'Whole Internal Refurbishment', '', '1', 'whole-internal-refurbishment-145', 0, '2022-06-08 06:20:27', NULL, NULL),
(146, 0, 'Stone Masonry and Stonework', '', '1', 'stone-masonry-and-stonework-146', 0, '2022-06-08 06:20:44', NULL, NULL),
(147, 146, 'Stone Cleaning and Sealing', '', '1', 'stone-cleaning-and-sealing-147', 0, '2022-06-08 06:21:01', NULL, NULL),
(148, 146, 'Outdoor Fireplaces and Kitchens', '', '1', 'outdoor-fireplaces-and-kitchens-148', 0, '2022-06-08 06:21:11', NULL, NULL),
(149, 146, 'Natural Stone Patios and Walkways', '', '1', 'natural-stone-patios-and-walkways-149', 0, '2022-06-08 06:21:21', NULL, NULL),
(150, 146, 'Retaining Walls and Garden Beds', '', '1', 'retaining-walls-and-garden-beds-150', 0, '2022-06-08 06:21:34', NULL, NULL),
(151, 146, 'Water Features and Landscaping', '', '1', 'water-features-and-landscaping-151', 0, '2022-06-08 06:21:45', NULL, NULL),
(152, 146, 'Stone Veneer and Siding installation', '', '1', 'stone-veneer-and-siding-installation-152', 0, '2022-06-08 06:21:57', NULL, NULL),
(153, 146, 'Stone  Concrete Paving', '', '1', 'stone-concrete-paving-153', 0, '2022-06-08 06:22:08', NULL, NULL),
(154, 146, 'Stonework  Stone Cladding', '', '1', 'stonework-stone-cladding-154', 0, '2022-06-08 06:22:20', NULL, NULL),
(155, 0, 'Swimming Pool Installation', '', '1', 'swimming-pool-installation-155', 0, '2022-06-08 06:22:40', NULL, NULL),
(156, 155, 'Swimming Pool Design and Consultation', '', '1', 'swimming-pool-design-and-consultation-156', 0, '2022-06-08 06:22:59', NULL, NULL),
(157, 155, 'Swimming Pool Installation', '', '1', 'swimming-pool-installation-157', 0, '2022-06-08 06:23:09', NULL, NULL),
(158, 155, 'Pool Maintenance and Cleaning', '', '1', 'pool-maintenance-and-cleaning-158', 0, '2022-06-08 06:23:21', NULL, NULL),
(159, 0, 'Tiler', '', '0', 'tiler-159', 0, '2022-06-08 06:23:39', NULL, NULL),
(160, 0, 'Surveillance, Satellite and Alarm Systems', '', '1', 'surveillance-satellite-and-alarm-systems-160', 0, '2022-06-08 06:23:45', NULL, NULL),
(161, 159, 'External Tiling', '', '1', 'external-tiling-161', 0, '2022-06-08 06:24:00', NULL, NULL),
(162, 159, 'Floor Tiling', '', '1', 'floor-tiling-162', 0, '2022-06-08 06:24:14', NULL, NULL),
(163, 159, 'Wall Tiling', '', '1', 'wall-tiling-163', 0, '2022-06-08 06:24:25', NULL, NULL),
(164, 0, 'Traditional Craftsmanship', '', '1', 'traditional-craftsmanship-164', 0, '2022-06-08 06:24:41', NULL, NULL),
(165, 164, 'Custom Furniture and Cabinetry', '', '1', 'custom-furniture-and-cabinetry-165', 0, '2022-06-08 06:25:03', NULL, NULL),
(166, 160, 'Smart Home Automation and Networking', '', '1', 'smart-home-automation-and-networking-166', 0, '2022-06-08 06:25:04', NULL, NULL),
(167, 164, 'Hand-carved Stone Fireplaces', '', '1', 'hand-carved-stone-fireplaces-167', 0, '2022-06-08 06:25:18', NULL, NULL),
(168, 160, 'Security and Surveillance Camera Systems', '', '1', 'security-and-surveillance-camera-systems-168', 0, '2022-06-08 06:25:28', NULL, NULL),
(169, 164, 'Antique and Reproduction Lighting', '', '1', 'antique-and-reproduction-lighting-169', 0, '2022-06-08 06:25:32', NULL, NULL),
(170, 164, 'Hand-forged Ironwork and Metalwork', '', '1', 'hand-forged-ironwork-and-metalwork-170', 0, '2022-06-08 06:25:44', NULL, NULL),
(171, 160, 'Alarm Systems and Monitoring', '', '1', 'alarm-systems-and-monitoring-171', 0, '2022-06-08 06:25:44', NULL, NULL),
(172, 160, 'Home Theater and Sound Systems', '', '1', 'home-theater-and-sound-systems-172', 0, '2022-06-08 06:26:08', NULL, NULL),
(173, 160, 'Digital Home Network', '', '1', 'digital-home-network-173', 0, '2022-06-08 06:26:27', NULL, NULL),
(174, 160, 'Fire Alarm Installation', '', '1', 'fire-alarm-installation-174', 0, '2022-06-08 06:26:47', NULL, NULL),
(175, 160, 'Sound & Audio Visual Installation', '', '1', 'sound-and-audio-visual-installation-175', 0, '2022-06-08 06:27:05', NULL, NULL),
(176, 164, 'Hand-painted Murals and Faux Finishes', '', '1', 'hand-painted-murals-and-faux-finishes-176', 0, '2022-06-08 06:29:29', NULL, NULL),
(177, 0, 'Carpentry and Joinery', '', '1', 'carpentry-and-joinery-177', 0, '2022-06-08 06:29:38', NULL, NULL),
(178, 164, 'Plaster and Woodwork Restoration', '', '1', 'plaster-and-woodwork-restoration-178', 0, '2022-06-08 06:29:41', NULL, NULL),
(179, 164, 'Historic Preservation and Conservation', '', '1', 'historic-preservation-and-conservation-179', 0, '2022-06-08 06:29:53', NULL, NULL),
(180, 164, 'Thatched Roof', '', '1', 'thatched-roof-180', 0, '2022-06-08 06:30:09', NULL, NULL),
(181, 164, 'Wall Murals  Paint Effects', '', '1', 'wall-murals-paint-effects-181', 0, '2022-06-08 06:30:19', NULL, NULL),
(182, 164, 'Wooden Doors - Internal', '', '1', 'wooden-doors---internal-182', 0, '2022-06-08 06:30:31', NULL, NULL),
(183, 164, 'Wooden Shutter', '', '1', 'wooden-shutter-183', 0, '2022-06-08 06:30:45', NULL, NULL),
(184, 177, 'Custom Furniture and Cabinetry', '', '1', 'custom-furniture-and-cabinetry-184', 0, '2022-06-08 06:30:50', NULL, NULL),
(185, 0, 'Tree Care and Arboriculture', '', '1', 'tree-care-and-arboriculture-185', 0, '2022-06-08 06:30:57', NULL, NULL),
(186, 177, 'Bespoke Kitchen Design and Installation', '', '1', 'bespoke-kitchen-design-and-installation-186', 0, '2022-06-08 06:31:16', NULL, NULL),
(187, 185, 'Crown Reduction', '', '1', 'crown-reduction-187', 0, '2022-06-08 06:31:22', NULL, NULL),
(188, 185, 'Crown Thinning', '', '1', 'crown-thinning-188', 0, '2022-06-08 06:31:32', NULL, NULL),
(189, 177, 'Built-In Furnishings and Shelving', '', '1', 'built-in-furnishings-and-shelving-189', 0, '2022-06-08 06:31:41', NULL, NULL),
(190, 185, 'Stump Grinding', '', '1', 'stump-grinding-190', 0, '2022-06-08 06:31:45', NULL, NULL),
(191, 185, 'Tree Felling', '', '1', 'tree-felling-191', 0, '2022-06-08 06:31:57', NULL, NULL),
(192, 177, 'Fitted Bedrooms and Wardrobes', '', '1', 'fitted-bedrooms-and-wardrobes-192', 0, '2022-06-08 06:32:01', NULL, NULL),
(193, 185, 'Tree Surgery / Consultancy', '', '1', 'tree-surgery-consultancy-193', 0, '2022-06-08 06:32:10', NULL, NULL),
(194, 0, 'Window and Conservatory Installation', '', '1', 'window-and-conservatory-installation-194', 0, '2022-06-08 06:32:33', NULL, NULL),
(195, 177, 'Assembly of Flat-Packed Furniture', '', '1', 'assembly-of-flat-packed-furniture-195', 0, '2022-06-08 06:32:35', NULL, NULL),
(196, 194, 'Conservatory', '', '1', 'conservatory-196', 0, '2022-06-08 06:33:02', NULL, NULL),
(197, 177, 'Floor Sanding and Finishing', '', '1', 'floor-sanding-and-finishing-197', 0, '2022-06-08 06:33:03', NULL, NULL),
(198, 194, 'Conservatory Cleaning / Maintenance', '', '1', 'conservatory-cleaning-maintenance-198', 0, '2022-06-08 06:33:15', NULL, NULL),
(199, 177, 'Garden Sheds and Playhouses', '', '1', 'garden-sheds-and-playhouses-199', 0, '2022-06-08 06:33:27', NULL, NULL),
(200, 194, 'Decorative Glazing', '', '1', 'decorative-glazing-200', 0, '2022-06-08 06:33:34', NULL, NULL),
(201, 194, 'Perspex / Protective Screens', '', '1', 'perspex-protective-screens-201', 0, '2022-06-08 06:33:44', NULL, NULL),
(202, 177, 'General Carpentry Services', '', '1', 'general-carpentry-services-202', 0, '2022-06-08 06:33:48', NULL, NULL),
(203, 194, 'Single / Double Glazing', '', '1', 'single-double-glazing-203', 0, '2022-06-08 06:33:54', NULL, NULL),
(204, 194, 'uPVC Windows & Door', '', '1', 'upvc-windows-and-door-204', 0, '2022-06-08 06:34:07', NULL, NULL),
(205, 177, 'Hot Tub Installation and Repairs', '', '1', 'hot-tub-installation-and-repairs-205', 0, '2022-06-08 06:34:11', NULL, NULL),
(206, 194, 'Velux / Skylight Window', '', '1', 'velux-skylight-window-206', 0, '2022-06-08 06:34:18', NULL, NULL),
(207, 194, 'Wooden Casement Window', '', '1', 'wooden-casement-window-207', 0, '2022-06-08 06:34:29', NULL, NULL),
(208, 177, 'Laminate Flooring', '', '1', 'laminate-flooring-208', 0, '2022-06-08 06:34:32', NULL, NULL),
(209, 194, 'Wooden Doors - External', '', '1', 'wooden-doors---external-209', 0, '2022-06-08 06:34:55', NULL, NULL),
(210, 177, 'Timber-Framed Building and Log Cabins', '', '1', 'timber-framed-building-and-log-cabins-210', 0, '2022-06-08 06:34:58', NULL, NULL),
(211, 194, 'Wooden Sash Window', '', '1', 'wooden-sash-window-211', 0, '2022-06-08 06:35:05', NULL, NULL),
(212, 177, 'Restoration for Historic and Listed Buildings', '', '1', 'restoration-for-historic-and-listed-buildings-212', 0, '2022-06-08 06:35:23', NULL, NULL),
(213, 177, 'Radiator Covers', '', '1', 'radiator-covers-213', 0, '2022-06-08 06:35:45', NULL, NULL),
(214, 177, 'Skirting Board Installation', '', '1', 'skirting-board-installation-214', 0, '2022-06-08 06:36:09', NULL, NULL),
(215, 177, 'Solid Hardwood Flooring', '', '1', 'solid-hardwood-flooring-215', 0, '2022-06-08 06:36:31', NULL, NULL),
(216, 177, 'Wooden Cladding, Fascias and Soffits', '', '1', 'wooden-cladding-fascias-and-soffits-216', 0, '2022-06-08 06:36:53', NULL, NULL),
(217, 177, 'Wooden Decking and Patios', '', '1', 'wooden-decking-and-patios-217', 0, '2022-06-08 06:37:08', NULL, NULL),
(218, 177, 'External Wooden Doors and Gates', '', '1', 'external-wooden-doors-and-gates-218', 0, '2022-06-08 06:37:27', NULL, NULL),
(219, 177, 'Internal Wooden Doors', '', '1', 'internal-wooden-doors-219', 0, '2022-06-08 06:37:47', NULL, NULL),
(220, 177, 'Wooden Sash Windows', '', '1', 'wooden-sash-windows-220', 0, '2022-06-08 06:38:06', NULL, NULL),
(221, 177, 'Wooden Shutters', '', '1', 'wooden-shutters-221', 0, '2022-06-08 06:38:25', NULL, NULL),
(222, 177, 'Wooden Staircases and Railings', '', '1', 'wooden-staircases-and-railings-222', 0, '2022-06-08 06:38:44', NULL, NULL),
(223, 177, 'Wooden Shutter', '', '0', 'wooden-shutter-223', 0, '2022-06-08 06:39:05', NULL, NULL),
(224, 177, 'Wooden Staircases', '', '0', 'wooden-staircases-224', 0, '2022-06-08 06:39:44', NULL, NULL),
(225, 0, 'Cleaning', '', '1', 'cleaning-225', 0, '2022-06-08 06:40:49', NULL, NULL),
(226, 225, 'Cleaning Carpet ', '', '1', 'cleaning-carpet-226', 0, '2022-06-08 06:41:27', NULL, NULL),
(227, 225, 'Commercial Window Cleaning', '', '1', 'commercial-window-cleaning-227', 0, '2022-06-08 06:41:47', NULL, NULL),
(228, 225, 'Conservatory Cleaning and Maintenance', '', '1', 'conservatory-cleaning-and-maintenance-228', 0, '2022-06-08 06:42:04', NULL, NULL),
(229, 225, 'Deep Cleaning for Commercial and Residential spaces', '', '1', 'deep-cleaning-for-commercial-and-residential-spaces-229', 0, '2022-06-08 06:42:23', NULL, NULL),
(230, 225, 'Deep Cleaning - Domestic', '', '0', 'deep-cleaning---domestic-230', 0, '2022-06-08 06:42:39', NULL, NULL),
(231, 225, 'One-Time and Regular House Cleaning', '', '1', 'one-time-and-regular-house-cleaning-231', 0, '2022-06-08 06:42:53', NULL, NULL),
(232, 225, 'Domestic House Cleaning: Regular', '', '0', 'domestic-house-cleaning-regular-232', 0, '2022-06-08 06:43:07', NULL, NULL),
(233, 225, 'End of Tenancy Cleaning', '', '1', 'end-of-tenancy-cleaning-233', 0, '2022-06-08 06:43:24', NULL, NULL),
(234, 225, 'Office and Commercial Cleaning', '', '1', 'office-and-commercial-cleaning-234', 0, '2022-06-08 06:43:44', NULL, NULL),
(235, 225, 'Oven Cleaning', '', '1', 'oven-cleaning-235', 0, '2022-06-08 06:43:59', NULL, NULL),
(236, 225, 'Post-Construction Cleaning', '', '1', 'post-construction-cleaning-236', 0, '2022-06-08 06:44:14', NULL, NULL),
(237, 225, 'Recurring Wheelie Bin Cleaning', '', '1', 'recurring-wheelie-bin-cleaning-237', 0, '2022-06-08 06:44:30', NULL, NULL),
(238, 225, 'Window Cleaning', '', '1', 'window-cleaning-238', 0, '2022-06-08 06:44:49', NULL, NULL),
(239, 0, 'Drainage Systems', '', '1', 'drainage-systems-239', 0, '2022-06-08 06:45:55', NULL, NULL),
(240, 239, 'Drain Installation, Cleaning and Unblocking', '', '1', 'drain-installation-cleaning-and-unblocking-240', 0, '2022-06-08 06:46:25', NULL, NULL),
(241, 239, ' Septic Tank Installation, Cleaning and Emptying', '', '1', '-septic-tank-installation-cleaning-and-emptying-241', 0, '2022-06-08 06:46:52', NULL, NULL),
(242, 0, 'Driveway Paving', '', '1', 'driveway-paving-242', 0, '2022-06-08 06:47:22', NULL, NULL),
(243, 242, 'Brick and Block Paving', '', '1', 'brick-and-block-paving-243', 0, '2022-06-08 06:47:46', NULL, NULL),
(244, 242, ' Concrete Driveway', '', '1', '-concrete-driveway-244', 0, '2022-06-08 06:48:04', NULL, NULL),
(245, 242, 'Resin-Bonded Driveways', '', '1', 'resin-bonded-driveways-245', 0, '2022-06-08 06:48:24', NULL, NULL),
(246, 242, 'Tarmac Driveway', '', '1', 'tarmac-driveway-246', 0, '2022-06-08 06:48:40', NULL, NULL),
(247, 0, 'Electrical Work', '', '1', 'electrical-work-247', 0, '2022-06-08 06:49:06', NULL, NULL),
(248, 247, 'Access Control and Door Entry Systems', '', '1', 'access-control-and-door-entry-systems-248', 0, '2022-06-08 06:49:42', NULL, NULL),
(249, 247, 'Aerial and Satellite Dish Installation', '', '1', 'aerial-and-satellite-dish-installation-249', 0, '2022-06-08 06:49:59', NULL, NULL),
(250, 247, 'Air Conditioning and Refrigeration', '', '1', 'air-conditioning-and-refrigeration-250', 0, '2022-06-08 06:50:14', NULL, NULL),
(251, 247, 'Carbon Monoxide Alarm Installation', '', '1', 'carbon-monoxide-alarm-installation-251', 0, '2022-06-08 06:50:31', NULL, NULL),
(252, 247, 'Domestic Appliance Repairs', '', '1', 'domestic-appliance-repairs-252', 0, '2022-06-08 06:50:50', NULL, NULL),
(253, 247, 'Electric Vehicle Charging Station Installation', '', '1', 'electric-vehicle-charging-station-installation-253', 0, '2022-06-08 06:51:06', NULL, NULL),
(254, 247, 'Electric Oven and Stove Installation', '', '1', 'electric-oven-and-stove-installation-254', 0, '2022-06-08 06:51:24', NULL, NULL),
(255, 247, 'Electric Underfloor Heating', '', '1', 'electric-underfloor-heating-255', 0, '2022-06-08 06:51:39', NULL, NULL),
(256, 247, 'Electrical Inspection and Testing', '', '1', 'electrical-inspection-and-testing-256', 0, '2022-06-08 06:51:55', NULL, NULL),
(257, 247, 'Electrical Inspection Condition Report', '', '0', 'electrical-inspection-condition-report-257', 0, '2022-06-08 06:52:13', NULL, NULL),
(258, 247, 'Emergency Electrical Services', '', '1', 'emergency-electrical-services-258', 0, '2022-06-08 06:52:29', NULL, NULL),
(259, 247, 'Outdoor Lighting', '', '1', 'outdoor-lighting-259', 0, '2022-06-08 06:52:44', NULL, NULL),
(260, 247, 'Hot Tub Installation and Repairs', '', '1', 'hot-tub-installation-and-repairs-260', 0, '2022-06-08 06:53:00', NULL, NULL),
(261, 247, 'Indoor Lighting', '', '1', 'indoor-lighting-261', 0, '2022-06-08 06:53:17', NULL, NULL),
(262, 247, 'Landlord Safety Inspections', '', '1', 'landlord-safety-inspections-262', 0, '2022-06-08 06:53:32', NULL, NULL),
(263, 247, 'Smoke Alarm Installation', '', '1', 'smoke-alarm-installation-263', 0, '2022-06-08 06:53:48', NULL, NULL),
(264, 0, 'Flooring Installation', '', '1', 'flooring-installation-264', 0, '2022-06-08 06:54:20', NULL, NULL),
(265, 264, 'Carpet Installation', '', '1', 'carpet-installation-265', 0, '2022-06-08 06:55:00', NULL, NULL),
(266, 264, 'Electric Underfloor Heating', '', '1', 'electric-underfloor-heating-266', 0, '2022-06-08 06:55:17', NULL, NULL),
(267, 264, 'Exterior Tiling', '', '1', 'exterior-tiling-267', 0, '2022-06-08 06:55:36', NULL, NULL),
(268, 264, 'Floor Sanding and Finishing', '', '1', 'floor-sanding-and-finishing-268', 0, '2022-06-08 06:55:57', NULL, NULL),
(269, 264, 'Floor Tiling', '', '1', 'floor-tiling-269', 0, '2022-06-08 06:56:16', NULL, NULL),
(270, 264, 'Laminate Flooring', '', '1', 'laminate-flooring-270', 0, '2022-06-08 06:56:32', NULL, NULL),
(271, 264, 'Linoleum Flooring', '', '1', 'linoleum-flooring-271', 0, '2022-06-08 06:56:47', NULL, NULL),
(272, 264, 'Plastic and Rubber Flooring', '', '1', 'plastic-and-rubber-flooring-272', 0, '2022-06-08 06:57:05', NULL, NULL),
(273, 264, 'Polished Concrete', '', '1', 'polished-concrete-273', 0, '2022-06-08 06:57:18', NULL, NULL),
(274, 264, 'Screeding', '', '1', 'screeding-274', 0, '2022-06-08 06:57:33', NULL, NULL),
(275, 264, 'Solid Hardwood Flooring', '', '1', 'solid-hardwood-flooring-275', 0, '2022-06-08 06:57:47', NULL, NULL),
(276, 264, 'Stone and Concrete Paving', '', '1', 'stone-and-concrete-paving-276', 0, '2022-06-08 06:58:01', NULL, NULL),
(277, 264, 'Vinyl Flooring', '', '1', 'vinyl-flooring-277', 0, '2022-06-08 06:58:15', NULL, NULL),
(278, 264, 'Water Underfloor Heating', '', '1', 'water-underfloor-heating-278', 0, '2022-06-08 06:58:29', NULL, NULL),
(279, 264, 'Wooden Decking and Patios', '', '1', 'wooden-decking-and-patios-279', 0, '2022-06-08 06:58:48', NULL, NULL),
(281, 11, 'Brick and Block Paving', '', '1', 'brick-and-block-paving-281', 0, '2022-06-08 07:00:18', NULL, NULL),
(282, 11, 'Garden Clearance', '', '1', 'garden-clearance-282', 0, '2022-06-08 07:00:33', NULL, NULL),
(283, 11, 'Landscape Design and Planning', '', '1', 'landscape-design-and-planning-283', 0, '2022-06-08 07:00:51', NULL, NULL),
(284, 11, 'Garden Maintenance & Repair', '', '1', 'garden-maintenance-and-repair-284', 0, '2022-06-08 07:01:08', NULL, NULL),
(285, 11, 'Garden Sheds and Playhouses', '', '1', 'garden-sheds-and-playhouses-285', 0, '2022-06-08 07:01:23', NULL, NULL),
(286, 11, 'Garden Walls', '', '1', 'garden-walls-286', 0, '2022-06-08 07:01:37', NULL, NULL),
(287, 11, 'Landscaping Design & Construction', '', '1', 'landscaping-design-and-construction-287', 0, '2022-06-08 07:01:57', NULL, NULL),
(288, 11, 'Lawn Care Services - Grass Cutting, Turfing and Seeding', '', '1', 'lawn-care-services---grass-cutting-turfing-and-seeding-288', 0, '2022-06-08 07:02:12', NULL, NULL),
(289, 11, 'Planting and Horticulture', '', '1', 'planting-and-horticulture-289', 0, '2022-06-08 07:02:30', NULL, NULL),
(290, 11, 'Pond and Water Feature Installation', '', '1', 'pond-and-water-feature-installation-290', 0, '2022-06-08 07:02:50', NULL, NULL),
(291, 11, 'Recurring Garden Maintenance', '', '1', 'recurring-garden-maintenance-291', 0, '2022-06-08 07:03:05', NULL, NULL),
(292, 11, 'Soil Irrigation and Drainage', '', '1', 'soil-irrigation-and-drainage-292', 0, '2022-06-08 07:03:20', NULL, NULL),
(293, 11, 'Stone and Concrete Paving', '', '1', 'stone-and-concrete-paving-293', 0, '2022-06-08 07:03:36', NULL, NULL),
(294, 11, 'Tree Surgery and Consultancy', '', '1', 'tree-surgery-and-consultancy-294', 0, '2022-06-08 07:03:53', NULL, NULL),
(295, 11, 'Wooden, Metal and Wire Fencing', '', '1', 'wooden-metal-and-wire-fencing-295', 0, '2022-06-08 07:04:08', NULL, NULL),
(296, 11, 'Wooden and Metal Gates', '', '1', 'wooden-and-metal-gates-296', 0, '2022-06-08 07:04:24', NULL, NULL),
(297, 11, 'Wooden Decking and Patios', '', '1', 'wooden-decking-and-patios-297', 0, '2022-06-08 07:04:40', NULL, NULL),
(298, 0, 'Heating and Gas Engineering', '', '1', 'heating-and-gas-engineering-298', 0, '2022-06-08 07:05:19', NULL, NULL),
(299, 298, 'Electric Boiler Installation and Repairs', '', '1', 'electric-boiler-installation-and-repairs-299', 0, '2022-06-08 07:05:40', NULL, NULL),
(300, 298, 'Electric Boiler - Service / Repair', '', '0', 'electric-boiler---service-repair-300', 0, '2022-06-08 07:06:00', NULL, NULL),
(301, 298, 'Gas Boiler Installation and Repairs', '', '1', 'gas-boiler-installation-and-repairs-301', 0, '2022-06-08 07:06:20', NULL, NULL),
(302, 298, 'Gas Boiler - Service / Repair', '', '0', 'gas-boiler---service-repair-302', 0, '2022-06-08 07:06:36', NULL, NULL),
(303, 298, 'Gas Cooker and Stove Installation and Repairs', '', '1', 'gas-cooker-and-stove-installation-and-repairs-303', 0, '2022-06-08 07:06:54', NULL, NULL),
(304, 298, 'Gas Cooker / Hob - Repair', '', '0', 'gas-cooker-hob---repair-304', 0, '2022-06-08 07:07:06', NULL, NULL),
(305, 298, 'Gas Fireplace Installation and Repairs', '', '1', 'gas-fireplace-installation-and-repairs-305', 0, '2022-06-08 07:07:19', NULL, NULL),
(306, 298, 'Heat Pump Installation (Air source Ground Source)', '', '1', 'heat-pump-installation-air-source-ground-source-306', 0, '2022-06-08 07:07:36', NULL, NULL),
(307, 298, 'Hot Water Tank and Appliance Thermostats', '', '1', 'hot-water-tank-and-appliance-thermostats-307', 0, '2022-06-08 07:07:51', NULL, NULL),
(308, 298, 'Oil-Fired Boiler Installation and Repairs', '', '1', 'oil-fired-boiler-installation-and-repairs-308', 0, '2022-06-08 07:08:07', NULL, NULL),
(309, 298, 'Radiator Installation and Repairs', '', '1', 'radiator-installation-and-repairs-309', 0, '2022-06-08 07:08:20', NULL, NULL),
(310, 298, 'Solar Panel Installation', '', '1', 'solar-panel-installation-310', 0, '2022-06-08 07:08:33', NULL, NULL),
(311, 298, 'Water Underfloor Heating', '', '1', 'water-underfloor-heating-311', 0, '2022-06-08 07:08:51', NULL, NULL),
(312, 0, 'Handyman Services', '', '1', 'handyman-services-312', 0, '2022-06-08 07:09:59', NULL, NULL),
(313, 312, 'Blind, Curtain and Shutter Installation', '', '1', 'blind-curtain-and-shutter-installation-313', 0, '2022-06-08 07:10:14', NULL, NULL),
(314, 312, 'Cat Flap Installation', '', '1', 'cat-flap-installation-314', 0, '2022-06-08 07:10:30', NULL, NULL),
(315, 312, 'Domestic Appliance Repairs', '', '1', 'domestic-appliance-repairs-315', 0, '2022-06-08 07:10:48', NULL, NULL),
(316, 312, 'Electric Oven and Stove Installation', '', '1', 'electric-oven-and-stove-installation-316', 0, '2022-06-08 07:11:02', NULL, NULL),
(317, 312, 'Assembly of Flat-Packed Furniture', '', '1', 'assembly-of-flat-packed-furniture-317', 0, '2022-06-08 07:11:14', NULL, NULL),
(318, 312, 'Home Maintenance and Repairs', '', '1', 'home-maintenance-and-repairs-318', 0, '2022-06-08 07:11:27', NULL, NULL),
(319, 312, 'Pressure Washing', '', '1', 'pressure-washing-319', 0, '2022-06-08 07:11:42', NULL, NULL),
(320, 312, 'Perspex and Protective Screen Installation', '', '1', 'perspex-and-protective-screen-installation-320', 0, '2022-06-08 07:11:54', NULL, NULL),
(321, 312, 'Skirting Board Installation', '', '1', 'skirting-board-installation-321', 0, '2022-06-08 07:12:12', NULL, NULL),
(322, 0, 'Kitchen Design and Installation', '', '1', 'kitchen-design-and-installation-322', 0, '2022-06-08 07:12:47', NULL, NULL),
(323, 322, 'Kitchen Cabinetry and Countertops', '', '1', 'kitchen-cabinetry-and-countertops-323', 0, '2022-06-08 07:13:05', NULL, NULL),
(324, 322, 'Kitchen Appliance Installation', '', '1', 'kitchen-appliance-installation-324', 0, '2022-06-08 07:13:18', NULL, NULL),
(325, 322, 'Kitchen Lighting and Electrical', '', '1', 'kitchen-lighting-and-electrical-325', 0, '2022-06-08 07:13:32', NULL, NULL),
(326, 322, 'Kitchen Flooring and Tiling', '', '1', 'kitchen-flooring-and-tiling-326', 0, '2022-06-08 07:13:47', NULL, NULL),
(327, 322, 'Kitchen Plumbing and Gas', '', '1', 'kitchen-plumbing-and-gas-327', 0, '2022-06-08 07:14:03', NULL, NULL),
(328, 322, 'Kitchen Remodeling and Renovation', '', '1', 'kitchen-remodeling-and-renovation-328', 0, '2022-06-08 07:14:18', NULL, NULL),
(329, 322, 'Laminate  Wooden Kitchen Worktops', '', '1', 'laminate-wooden-kitchen-worktops-329', 0, '2022-06-08 07:14:34', NULL, NULL),
(330, 322, 'Metal Kitchen Worktops', '', '1', 'metal-kitchen-worktops-330', 0, '2022-06-08 07:14:48', NULL, NULL),
(331, 0, 'Locksmiths', '', '1', 'locksmiths-331', 0, '2022-06-08 07:15:17', NULL, NULL),
(332, 331, 'Burglary Damage Repair', '', '1', 'burglary-damage-repair-332', 0, '2022-06-08 07:15:35', NULL, NULL),
(333, 331, 'Emergency Door Opening', '', '1', 'emergency-door-opening-333', 0, '2022-06-08 07:15:49', NULL, NULL),
(334, 331, 'Door Replacement and Upgrades', '', '1', 'door-replacement-and-upgrades-334', 0, '2022-06-08 07:16:02', NULL, NULL),
(336, 331, 'Rekeying and Master Key Systems', '', '1', 'rekeying-and-master-key-systems-336', 0, '2022-06-08 07:16:40', NULL, NULL),
(337, 2, 'Metal Staircases', '', '1', 'metal-staircases-337', 0, '2022-06-09 07:29:35', NULL, NULL),
(338, 331, '24 Hour Emergency Locksmith Services', '', '1', '24-hour-emergency-locksmith-services-338', 0, '2022-06-10 09:58:36', NULL, NULL),
(339, 3, 'Brickwork and Masonry', '', '1', 'brickwork-and-masonry-339', 0, '2023-01-16 11:04:57', NULL, NULL),
(340, 331, 'Lock Installation and Repair', '', '1', 'lock-installation-and-repair-340', 0, '2023-01-17 11:01:04', NULL, NULL),
(341, 34, 'Wallpapering', '', '1', 'wallpapering-341', 0, '2023-01-17 11:36:44', NULL, NULL),
(342, 155, 'In-ground Swimming Pool Construction', '', '1', 'in-ground-swimming-pool-construction-342', 0, '2023-01-18 05:59:46', NULL, NULL),
(343, 155, ' Spa and Hot Tub installation', '', '1', '-spa-and-hot-tub-installation-343', 0, '2023-01-18 06:00:26', NULL, NULL),
(344, 155, 'Pool Heating and Cooling Systems', '', '1', 'pool-heating-and-cooling-systems-344', 0, '2023-01-18 06:01:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deleted_data`
--

CREATE TABLE `tbl_deleted_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `tbl` varchar(255) NOT NULL,
  `data` longtext NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_deleted_data`
--

INSERT INTO `tbl_deleted_data` (`id`, `tbl`, `data`, `created_at`) VALUES
(1, 'tbl_users', 'a:12:{s:2:\"id\";s:1:\"2\";s:10:\"country_id\";s:1:\"1\";s:4:\"name\";s:5:\"Osama\";s:5:\"email\";s:19:\"binladen@terror.com\";s:8:\"password\";s:32:\"e10adc3949ba59abbe56e057f20f883e\";s:5:\"phone\";s:10:\"9236987456\";s:11:\"description\";s:25:\"Terrorism is a bad thing.\";s:6:\"status\";s:1:\"0\";s:8:\"media_id\";s:1:\"4\";s:10:\"created_at\";s:19:\"2022-01-12 18:17:41\";s:10:\"updated_at\";s:19:\"2022-01-12 18:17:41\";s:10:\"deleted_at\";N;}', 1641991677),
(2, 'tbl_users', 'a:8:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:3:\"qwd\";s:7:\"user_id\";s:1:\"1\";s:4:\"type\";s:1:\"1\";s:8:\"media_id\";s:2:\"21\";s:10:\"updated_at\";s:19:\"2022-01-13 16:34:53\";s:10:\"created_at\";s:19:\"2022-01-13 16:34:53\";s:10:\"deleted_at\";N;}', 1642075610),
(3, 'tbl_users', 'a:8:{s:2:\"id\";s:1:\"3\";s:5:\"title\";s:4:\"ffgg\";s:7:\"user_id\";s:1:\"1\";s:4:\"type\";s:1:\"2\";s:8:\"media_id\";s:2:\"22\";s:10:\"updated_at\";s:19:\"2022-01-13 17:08:20\";s:10:\"created_at\";s:19:\"2022-01-13 17:08:20\";s:10:\"deleted_at\";N;}', 1642076263),
(4, 'tbl_users', 'a:8:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:5:\"qwdqw\";s:7:\"user_id\";s:1:\"1\";s:4:\"type\";s:1:\"1\";s:8:\"media_id\";s:2:\"26\";s:10:\"updated_at\";s:19:\"2022-01-13 18:53:54\";s:10:\"created_at\";s:19:\"2022-01-13 18:53:54\";s:10:\"deleted_at\";N;}', 1642080831);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_form`
--

CREATE TABLE `tbl_form` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `sub_category_id` int(11) NOT NULL DEFAULT 0,
  `form_title` text NOT NULL,
  `data` longtext NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
