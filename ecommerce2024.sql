-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2024 lúc 05:14 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ecommerce2024`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(75, 5, 9, 1, '2024-10-17 18:20:14', '2024-10-17 18:20:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `manufacturer`) VALUES
(8, 'Bình dân', '2024-09-05 18:33:03', '2024-09-05 20:04:50', 'loonvuitoiii'),
(9, 'Cao cấp', '2024-09-05 18:50:40', '2024-09-05 20:00:49', 'loonvuitoiii'),
(10, 'Vip', '2024-09-05 20:17:08', '2024-09-05 20:17:08', 'cha neo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_30_011132_create_categories_table', 1),
(5, '2024_09_06_003909_create_products_table', 2),
(6, '2024_09_06_005031_create_products_table', 3),
(7, '2024_09_06_005556_add_manufacturer_to_categories_table', 4),
(8, '2024_09_20_015041_create_carts_table', 5),
(9, '2024_09_26_115129_create_orders_table', 6),
(10, '2024_09_26_115145_create_payments_table', 6),
(11, '2024_09_26_125100_create_orders_table', 7),
(12, '2024_09_26_125107_create_payments_table', 7),
(13, '2024_09_26_161022_create_order_product_table', 8),
(14, '2024_10_02_072246_add_request_cancel_to_orders_table', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','completed','cancelled','confirmed','paid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_cancel` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `phone`, `payment_method`, `total_price`, `status`, `created_at`, `updated_at`, `request_cancel`) VALUES
(48, 1, 'Đỗ Nho Tú', 'HN', '0344780310', 'cod', 2993333, 'completed', '2024-10-04 06:12:12', '2024-10-04 06:17:42', 0),
(49, 3, 'Đỗ Nho Tú', 'HN', '0344780310', 'momo', 900000, 'completed', '2024-10-04 07:38:08', '2024-10-04 07:40:01', 0),
(50, 1, 'Đỗ Nho Tú', 'HN', '0344780310', 'cod', 1020300, 'cancelled', '2024-10-04 07:51:13', '2024-10-23 08:51:43', 0),
(54, 2, 'John Doe', '123 Main St', '0123456789', 'cod', 1020300, 'pending', '2024-10-15 11:03:16', '2024-10-15 11:03:16', 0),
(55, 2, 'John Doe', '123 Main St', '0123456789', 'cod', 603000, 'completed', '2024-10-15 11:21:44', '2024-10-20 15:42:32', 0),
(56, 2, 'John Doe', '123 Main St', '0123456789', 'cod', 603000, 'confirmed', '2024-10-15 11:24:56', '2024-10-17 17:28:32', 0),
(57, 1, 'Đỗ Nho Tú', 'HN', '0344780310', 'momo', 900000, 'completed', '2024-10-17 07:48:10', '2024-10-20 15:42:56', 0),
(92, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 790333, 'completed', '2024-10-20 15:13:40', '2024-10-20 15:27:56', 0),
(93, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 790333, 'completed', '2024-10-20 15:15:13', '2024-10-20 15:27:59', 0),
(98, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 1020300, 'paid', '2024-10-20 16:29:22', '2024-10-20 16:30:38', 0),
(101, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 1020300, 'paid', '2024-10-20 16:48:22', '2024-10-20 17:30:41', 0),
(103, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 1020300, 'paid', '2024-10-20 17:32:45', '2024-10-20 17:38:26', 0),
(104, 1, 'Đỗ Nho Tú', '48 btl', '0344780310', 'momo', 635000, 'completed', '2024-10-20 17:38:47', '2024-10-20 17:43:36', 0),
(105, 1, 'Do nho tu', '12 ngõ 291, Phường Kim Mã, Quận Ba Đình, Thành phố Hà Nội', '0344780310', 'cod', 1020300, 'cancelled', '2024-10-22 01:46:12', '2024-10-24 15:48:33', 0),
(110, 1, 'Do nho tu', '12 ngõ 291, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', '0344780310', 'momo', 2040600, 'paid', '2024-10-22 02:49:21', '2024-10-22 02:50:15', 0),
(111, 2, 'Do nho tu', '12 ngõ 291, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', '0344780310', 'momo', 2020500, 'completed', '2024-10-23 08:04:46', '2024-10-24 10:33:09', 0),
(112, 1, 'Đỗ Nho Tú', '12 ngõ 291, Phường Phú Diễn, Quận Bắc Từ Liêm, Thành phố Hà Nội', '0344780310', 'momo', 603000, 'paid', '2024-10-24 10:58:38', '2024-10-24 11:04:09', 0),
(116, 2, 'Đỗ Nho Tú', '12 ngõ 291, Xã Văn Khê, Huyện Mê Linh, Thành phố Hà Nội', '0344780310', 'momo', 900000, 'cancelled', '2024-10-24 14:53:43', '2024-10-24 15:45:01', 0),
(117, 2, 'Đỗ Nho Tú', '12 ngõ 291, Xã Hoàng Kim, Huyện Mê Linh, Thành phố Hà Nội', '0344780310', 'momo_qr', 1020300, 'completed', '2024-10-24 15:00:33', '2024-10-24 15:14:13', 0),
(118, 2, 'Đỗ Nho Tú', '12 ngõ 291, Phường Đồng Mai, Quận Hà Đông, Thành phố Hà Nội', '0344780310', 'momo_qr', 1020300, 'completed', '2024-10-24 15:02:53', '2024-10-24 15:12:04', 0),
(119, 1, 'Đỗ Nho Tú', '12 ngõ 291, Xã Văn Khê, Huyện Mê Linh, Thành phố Hà Nội', '0344780310', 'momo_qr', 1020300, 'completed', '2024-10-24 15:21:40', '2024-10-24 15:27:36', 0),
(120, 2, 'Đỗ Nho Tú', '12 ngõ 291, Phường Lĩnh Nam, Quận Hoàng Mai, Thành phố Hà Nội', '0344780310', 'momo_qr', 1020300, 'completed', '2024-10-25 02:27:07', '2024-10-25 02:35:12', 0),
(121, 2, 'Đỗ Nho Tú', '12 ngõ 291, Phường Minh Khai, Quận Bắc Từ Liêm, Thành phố Hà Nội', '0344780310', 'momo', 790333, 'paid', '2024-10-25 02:30:06', '2024-10-25 02:33:22', 0),
(122, 2, 'Đỗ Nho Tú', '12 ngõ 291, Thị trấn Trâu Quỳ, Huyện Gia Lâm, Thành phố Hà Nội', '0344780310', 'momo_qr', 2940600, 'pending', '2024-10-25 03:00:30', '2024-10-25 03:00:30', 0),
(123, 2, 'Đỗ Nho Tú', '12 ngõ 291, Phường Phú Lương, Quận Hà Đông, Thành phố Hà Nội', '0344780310', 'momo', 1020300, 'completed', '2024-10-25 03:01:39', '2024-10-25 03:05:50', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(34, 48, 3, 1, NULL, NULL),
(35, 48, 9, 1, NULL, NULL),
(36, 48, 7, 1, NULL, NULL),
(37, 49, 5, 1, NULL, NULL),
(38, 50, 4, 1, NULL, NULL),
(42, 54, 4, 1, NULL, NULL),
(43, 55, 3, 1, NULL, NULL),
(44, 56, 3, 1, NULL, NULL),
(45, 57, 5, 1, NULL, NULL),
(67, 92, 9, 1, NULL, NULL),
(68, 93, 9, 1, NULL, NULL),
(74, 98, 4, 1, NULL, NULL),
(77, 101, 4, 1, NULL, NULL),
(79, 103, 4, 1, NULL, NULL),
(80, 104, 10, 1, NULL, NULL),
(81, 105, 4, 1, NULL, NULL),
(86, 110, 4, 2, NULL, NULL),
(87, 111, 4, 1, NULL, NULL),
(88, 111, 12, 1, NULL, NULL),
(89, 112, 3, 1, NULL, NULL),
(94, 116, 5, 1, NULL, NULL),
(95, 117, 4, 1, NULL, NULL),
(96, 118, 4, 1, NULL, NULL),
(97, 119, 4, 1, NULL, NULL),
(98, 120, 4, 1, NULL, NULL),
(99, 121, 9, 1, NULL, NULL),
(100, 122, 4, 2, NULL, NULL),
(101, 122, 5, 1, NULL, NULL),
(102, 123, 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('tuaaa111@gmail.com', '$2y$12$dBIrnh7fLnPnJZ4AtMbyLeiAjW0u3lA6r8n0ifbS0X01yDacgpLfe', '2024-10-17 06:24:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `price`, `transaction_id`, `created_at`, `updated_at`) VALUES
(28, 48, 'cod', 2993333, NULL, '2024-10-04 06:12:12', '2024-10-04 06:12:12'),
(29, 49, 'momo', 900000, NULL, '2024-10-04 07:38:08', '2024-10-04 07:38:08'),
(30, 50, 'cod', 1020300, NULL, '2024-10-04 07:51:13', '2024-10-04 07:51:13'),
(34, 54, 'cod', 1020300, NULL, '2024-10-15 11:03:16', '2024-10-15 11:03:16'),
(35, 55, 'cod', 603000, NULL, '2024-10-15 11:21:44', '2024-10-15 11:21:44'),
(36, 56, 'cod', 603000, NULL, '2024-10-15 11:24:56', '2024-10-15 11:24:56'),
(37, 57, 'momo', 900000, NULL, '2024-10-17 07:48:10', '2024-10-17 07:48:10'),
(72, 92, 'momo', 790333, NULL, '2024-10-20 15:13:40', '2024-10-20 15:13:40'),
(73, 93, 'momo', 790333, NULL, '2024-10-20 15:15:13', '2024-10-20 15:15:13'),
(78, 98, 'momo', 1020300, NULL, '2024-10-20 16:29:22', '2024-10-20 16:29:22'),
(81, 101, 'momo', 1020300, NULL, '2024-10-20 16:48:22', '2024-10-20 16:48:22'),
(83, 103, 'momo', 1020300, NULL, '2024-10-20 17:32:45', '2024-10-20 17:32:45'),
(84, 104, 'momo', 635000, NULL, '2024-10-20 17:38:47', '2024-10-20 17:38:47'),
(85, 105, 'cod', 1020300, NULL, '2024-10-22 01:46:12', '2024-10-22 01:46:12'),
(90, 110, 'momo', 2040600, NULL, '2024-10-22 02:49:21', '2024-10-22 02:49:21'),
(91, 111, 'momo', 2020500, NULL, '2024-10-23 08:04:46', '2024-10-23 08:04:46'),
(92, 112, 'momo', 603000, NULL, '2024-10-24 10:58:38', '2024-10-24 10:58:38'),
(96, 116, 'momo', 900000, NULL, '2024-10-24 14:53:43', '2024-10-24 14:53:43'),
(97, 117, 'momo_qr', 1020300, NULL, '2024-10-24 15:00:33', '2024-10-24 15:00:33'),
(99, 119, 'momo_qr', 1020300, NULL, '2024-10-24 15:21:40', '2024-10-24 15:21:40'),
(100, 120, 'momo_qr', 1020300, NULL, '2024-10-25 02:27:07', '2024-10-25 02:27:07'),
(101, 121, 'momo', 790333, NULL, '2024-10-25 02:30:06', '2024-10-25 02:30:06'),
(102, 122, 'momo_qr', 2940600, NULL, '2024-10-25 03:00:30', '2024-10-25 03:00:30'),
(103, 123, 'momo', 1020300, NULL, '2024-10-25 03:01:39', '2024-10-25 03:01:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(12) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `quantity`, `price`, `category_id`, `created_at`, `updated_at`, `image`) VALUES
(3, 'Giày sandal cách điệu', 'Mã sản phẩm: 1010SDN0803\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Gót loe\r\nĐộ cao gót: 7 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nKiểu giày: Sandals', 83, 603000, 10, '2024-09-05 19:58:22', '2024-10-24 14:26:55', '1726810744.jpg'),
(4, 'Giày slingback t-strap cách điệu', 'Mã sản phẩm: 1010BMN0676\r\nLoại sản phẩm: Giày Bít\r\nKiểu gót: Gót dạng khối\r\nĐộ cao gót: 6 cm\r\nLoại mũi: Bít mũi tròn\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi tiệc, đi chơi\r\nKiểu giày: Pumps', 56, 1020300, 9, '2024-09-05 19:59:12', '2024-10-25 03:01:39', '1726810784.jpg'),
(5, 'Giày sandals gladiator platform', 'Mã sản phẩm: 1010SDN0800\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Gót có đúp\r\nĐộ cao gót: 11.5 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nKiểu giày: Sandals', 87, 900000, 9, '2024-09-05 20:18:55', '2024-10-25 03:00:32', '1726810932.jpg'),
(7, 'Giày bít mũi vuông ankle strap', 'Mã sản phẩm: 1010SDN0800\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Gót có đúp\r\nĐộ cao gót: 11.5 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nKiểu giày: Sandals', 95, 1600000, 10, '2024-09-08 06:16:18', '2024-10-20 16:40:58', '1726810942.jpg'),
(9, 'Giày sandal cách điệu', 'Mã sản phẩm: 1010SDN0800\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Gót có đúp\r\nĐộ cao gót: 11.5 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nKiểu giày: Sandals', 91, 790333, 8, '2024-09-19 22:34:15', '2024-10-25 02:30:07', '1726810759.jpg'),
(10, 'Giày slingback đế xuồng phối cói', 'Mã sản phẩm: 1010SDX0445\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Đế xuồng\r\nĐộ cao gót: 6 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nKiểu giày: Sandals', 48, 635000, 8, '2024-10-02 20:16:43', '2024-10-20 17:38:47', '1727925403.jpg'),
(11, 'Giày sandals vân kỳ đà nhấn gót aluminium', 'Mã sản phẩm: 1010SDN0798\r\nLoại sản phẩm: Giày Sandals\r\nKiểu gót: Gót dạng khối\r\nĐộ cao gót: 4 cm\r\nLoại mũi: Hở mũi\r\nChất liệu: Da nhân tạo dập vân nổi\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi\r\nHoa văn, chi tiết: Vân da kỳ đà\r\nKiểu giày: Sandals', 50, 635000, 8, '2024-10-02 20:17:58', '2024-10-02 20:17:58', '1727925478.jpg'),
(12, 'Bst splendid night - giày sandal ankle strap quai nhún chần bông', 'Mã sản phẩm: 1010SDN0742\r\nLoại sản phẩm: Giày Cao Gót\r\nKiểu gót: Gót nhọn\r\nĐộ cao gót: 8 cm\r\nLoại mũi: Hở mũi (mũi vuông)\r\nChất liệu: Da nhân tạo\r\nKiểu giày: Sandals\r\nPhù hợp sử dụng: Đi làm, đi học, đi chơi', 15, 1000200, 10, '2024-10-02 20:23:06', '2024-10-23 08:04:48', '1727925786.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4JNci3ZwxPssrVftqsQ3LbncZuPdZIP0s8JpfvXE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3pIYUw3SVFCUk52UjlDa3JaZnVMTmkxVG1PdWIzQTI4ODZNT1BhUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9vcmRlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1729825578),
('Ek5YT8TiHfF909gkNUmhLz1FeobnFjpmF9hiV3TB', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXVxR0tsSzJ2WUw1N1g0WUJGRXFEUlZNdEdmbEppWmhBNnRLY3RiNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9vcmRlcnM/cGFnZT0xIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1730174743);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin', 'kiintu94@gmail.com', NULL, '$2y$12$ZSGcxbyqRpNy28M3iWU50egnsKRmKvCzQMFYJBJnpvHv8dsHSBJbm', NULL, '2024-09-12 19:20:15', '2024-09-12 19:20:15', 'admin'),
(2, 'dotu', 'donhotu123@gmail.com', NULL, '$2y$12$p7Aa4re5dxhg5xFf3SJKVuWSmG2WrVQWlzGPRPfEccYlxZy40NkPO', NULL, '2024-09-16 08:17:19', '2024-10-25 02:05:52', 'user'),
(3, 'tu', 'tuaaa111@gmail.com', NULL, '$2y$12$0sQSsfspqZdjUcrSM/f4gOWVFWbDEB9RCRBzxDpM5O3b8TGRD1YaW', NULL, '2024-09-23 18:08:20', '2024-10-04 06:48:17', 'user'),
(4, 'John Doe', 'john@example.com', NULL, '$2y$12$vY6IktyiH7xIpWXlPJxtz.5bEl.an74yR.i.UYrkYWHd/waHluLbC', NULL, '2024-10-15 10:33:21', '2024-10-15 10:33:21', 'user'),
(5, 'tu', 'a@gmail.com', NULL, '$2y$12$fc7sx7UGPG.S.KXEGGVFoeL/z9Vuyv68jTjpEowYLzLjpmpCp9YoS', NULL, '2024-10-17 18:19:37', '2024-10-17 18:19:37', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT cho bảng `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
