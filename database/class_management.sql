-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 21, 2020 lúc 06:36 AM
-- Phiên bản máy phục vụ: 10.1.40-MariaDB
-- Phiên bản PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `class_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attend_classes`
--

CREATE TABLE `attend_classes` (
  `id` int(20) UNSIGNED NOT NULL,
  `class_id` int(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attend_classes`
--

INSERT INTO `attend_classes` (`id`, `class_id`, `student_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 1, '2020-10-14 12:41:39', '0000-00-00 00:00:00'),
(2, 1, 2, 1, '2020-10-22 15:47:13', '2020-10-15 08:31:44'),
(3, 2, 2, 1, '2020-11-20 21:18:10', '2020-11-20 21:18:10'),
(9, 7, 2, 3, '2020-11-20 22:07:28', '2020-11-20 22:07:28'),
(10, 8, 2, 3, '2020-11-20 22:35:00', '2020-11-20 22:35:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(20) UNSIGNED NOT NULL,
  `class_code` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `creator_id` int(11) NOT NULL,
  `room` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `class_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `class_image` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `classrooms`
--

INSERT INTO `classrooms` (`id`, `class_code`, `creator_id`, `room`, `class_name`, `subject`, `class_image`, `created_at`, `updated_at`) VALUES
(1, 'ID6059', 1, 'A3-245', 'Linux mã nguồn mở', 'Linix', 'images/class-1602411274.png', '2020-10-11 10:14:34', '2020-10-11 10:14:34'),
(2, 'ID9966', 1, 'alo', 'alo', 'alo', 'images/class-1602411322.png', '2020-10-11 10:15:22', '2020-10-11 10:15:22'),
(3, 'ID9702', 1, 'alo', 'alo', 'alo', 'images/class-1602412517.png', '2020-10-11 10:35:17', '2020-10-11 10:35:17'),
(4, 'ID3572', 1, 'alo', 'alo', 'alo', 'images/class-1602413211.png', '2020-10-11 10:46:51', '2020-10-11 10:46:51'),
(5, 'ID4921', 1, 'alo 456', 'Kỹ thuật', 'Đồ Họa', 'images/class-1602517915.png', '2020-10-12 15:51:55', '2020-10-12 15:51:55'),
(6, 'ID6688', 1, 'A3-245', 'Test', 'Tets ter', 'images/class-1602517998.png', '2020-10-12 15:53:18', '2020-10-12 15:53:18'),
(7, 'ID4381', 3, 'A3-246', 'Tiếng anh chuyên ngành', 'English', 'images/class-1605932084.jpeg', '2020-11-21 04:14:44', '2020-11-21 04:15:31'),
(8, 'ID9637', 3, 'A3-244', 'Tiếng anh giao tiếp', 'English', 'images/class-1605932475.jpeg', '2020-11-21 04:21:15', '2020-11-21 04:21:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `commentor` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` varchar(255) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `class_id`, `commentor`, `created_at`, `updated_at`, `content`) VALUES
(1, 1, 1, '2020-10-22 05:46:03', '2020-10-22 05:46:03', 'value=\"test lorem na\"'),
(2, 1, 1, '2020-10-22 05:54:44', '2020-10-22 05:54:44', 'test comment'),
(3, 1, 1, '2020-10-22 05:55:14', '2020-10-22 05:55:14', 'test 2'),
(9, 1, 2, '2020-10-22 08:49:02', '2020-10-22 08:49:02', 'test student'),
(10, 8, 3, '2020-11-20 22:10:58', '2020-11-20 22:10:58', 'cả lớp nhớ làm bài tập'),
(11, 8, 2, '2020-11-20 22:11:30', '2020-11-20 22:11:30', 'vâng thầy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf32_unicode_ci NOT NULL,
  `source` char(255) COLLATE utf32_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `documents`
--

INSERT INTO `documents` (`id`, `class_id`, `description`, `source`, `created_at`, `updated_at`) VALUES
(4, 1, 'Đề cương đồ án', 'documents/DoAnCuoiKi-v3.pdf', '2020-10-22 09:42:00', '2020-10-22 09:42:00'),
(5, 8, 'test up ảnh', 'documents/author2.png', '2020-11-20 22:10:24', '2020-11-20 22:10:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invite_joins`
--

CREATE TABLE `invite_joins` (
  `id` int(20) UNSIGNED NOT NULL,
  `teacher_id` int(20) NOT NULL,
  `class_id` int(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `invite_joins`
--

INSERT INTO `invite_joins` (`id`, `teacher_id`, `class_id`, `student_id`, `state`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 1, '2020-11-21 04:18:10', '2020-11-20 21:18:10'),
(2, 3, 7, 2, 1, '2020-11-21 05:07:28', '2020-11-20 22:07:28'),
(3, 3, 8, 2, 1, '2020-11-21 05:35:00', '2020-11-20 22:35:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('anhnv@gmail.com', '$2y$10$edgn7mJDX6zvBwORrM0/VeSTK5moHEoD1gG8s5TlWVn5jcBnrh/9e', '2020-10-10 21:44:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `request_joins`
--

CREATE TABLE `request_joins` (
  `id` int(20) UNSIGNED NOT NULL,
  `class_id` int(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `request_joins`
--

INSERT INTO `request_joins` (`id`, `class_id`, `student_id`, `state`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, '2020-11-21 04:22:36', '2020-11-20 21:22:36'),
(3, 6, 2, 0, '2020-10-23 23:20:17', '2020-10-23 23:20:17'),
(4, 8, 2, 1, '2020-11-21 05:02:31', '2020-11-20 22:02:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '3',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 1, NULL, '$2y$10$aYtRMrsMFr.3P9LEMs3o8uZ82kw0b5pZe2xS9hVmAJ1rWOTLuwK66', NULL, '2020-10-10 06:07:33', '2020-10-10 20:48:53'),
(2, 'Nguyễn Vân Anh', 'anhnv@gmail.com', 3, NULL, '$2y$10$NHh89Lc7dTuk52FqNSh7S.Z6ezQ/VKLmCSZRe6OfM.Y6BdeYvfMpe', NULL, '2020-10-10 06:08:43', '2020-10-11 09:29:18'),
(3, 'Thanh Tuấn', 'tuantt@gmail.com', 2, NULL, '$2y$10$ANtV0m.xoRupHupQLyVepO9BBRooB6cbZhH8aCS7wgoyZ.5Pda2.y', NULL, '2020-11-20 21:10:07', '2020-11-20 21:11:59');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attend_classes`
--
ALTER TABLE `attend_classes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invite_joins`
--
ALTER TABLE `invite_joins`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `request_joins`
--
ALTER TABLE `request_joins`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT cho bảng `attend_classes`
--
ALTER TABLE `attend_classes`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `invite_joins`
--
ALTER TABLE `invite_joins`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `request_joins`
--
ALTER TABLE `request_joins`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
