-- AstroVeda ERP MySQL Database Schema
-- Generated on 2026-06-15 18:21:54

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`name`) VALUES ('Super Admin');
INSERT INTO `roles` (`name`) VALUES ('Astrologer');
INSERT INTO `roles` (`name`) VALUES ('User');

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `module` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL UNIQUE,
    `mobile` varchar(255) NULL DEFAULT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `profile_image` varchar(255) NULL DEFAULT NULL,
    `status` tinyint NOT NULL DEFAULT 1,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `mobile_verified_at` timestamp NULL DEFAULT NULL,
    `last_login_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `role_id` bigint UNSIGNED NOT NULL,
    `permission_id` bigint UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_role_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE `user_profiles` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `gender` varchar(255) NULL DEFAULT NULL,
    `dob` date NULL DEFAULT NULL,
    `birth_time` time NULL DEFAULT NULL,
    `birth_place` varchar(255) NULL DEFAULT NULL,
    `latitude` decimal(10,8) NULL DEFAULT NULL,
    `longitude` decimal(11,8) NULL DEFAULT NULL,
    `marital_status` varchar(255) NULL DEFAULT NULL,
    `occupation` varchar(255) NULL DEFAULT NULL,
    `bio` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_user_profiles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE `user_addresses` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `address` text NULL DEFAULT NULL,
    `city` varchar(255) NULL DEFAULT NULL,
    `state` varchar(255) NULL DEFAULT NULL,
    `country` varchar(255) NULL DEFAULT NULL,
    `pincode` varchar(255) NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_user_addresses_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `astrologers`;
CREATE TABLE `astrologers` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `experience_years` int NOT NULL DEFAULT 0,
    `expertise` text NULL DEFAULT NULL,
    `languages` text NULL DEFAULT NULL,
    `bio` text NULL DEFAULT NULL,
    `rating` decimal(3,2) NOT NULL DEFAULT 0,
    `total_reviews` int NOT NULL DEFAULT 0,
    `approval_status` enum('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    `is_online` tinyint NOT NULL DEFAULT 0,
    `per_minute_charge` decimal(8,2) NOT NULL DEFAULT 35.00,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_astrologers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `astrologer_certificates`;
CREATE TABLE `astrologer_certificates` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `certificate_name` varchar(255) NOT NULL,
    `certificate_file` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_astrologer_certificates_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `astrologer_availability`;
CREATE TABLE `astrologer_availability` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `day_name` varchar(255) NOT NULL,
    `start_time` time NOT NULL,
    `end_time` time NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_astrologer_availability_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_categories` (`name`) VALUES ('Today\'s Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Marriage Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Career Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Business Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Weekly Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Monthly Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Yearly Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Health Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Love Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Education Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Child Prediction');
INSERT INTO `service_categories` (`name`) VALUES ('Property Prediction');

DROP TABLE IF EXISTS `astrologer_plans`;
CREATE TABLE `astrologer_plans` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `category_id` bigint UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text NULL DEFAULT NULL,
    `price` decimal(10,2) NOT NULL,
    `duration_days` int NOT NULL,
    `delivery_time` varchar(255) NOT NULL,
    `status` tinyint NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_astrologer_plans_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_astrologer_plans_category_id` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order_no` varchar(255) NOT NULL UNIQUE,
    `user_id` bigint UNSIGNED NOT NULL,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `plan_id` bigint UNSIGNED NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `discount` decimal(10,2) NOT NULL DEFAULT 0,
    `gst` decimal(10,2) NOT NULL DEFAULT 0,
    `final_amount` decimal(10,2) NOT NULL,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_orders_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_orders_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `astrologer_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order_id` bigint UNSIGNED NOT NULL,
    `plan_id` bigint UNSIGNED NOT NULL,
    `price` decimal(10,2) NOT NULL,
    `qty` int NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_order_items_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_order_items_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `astrologer_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `subscription_plans`;
CREATE TABLE `subscription_plans` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `price` decimal(10,2) NOT NULL,
    `duration` int NOT NULL,
    `features` json NULL DEFAULT NULL,
    `status` tinyint NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `user_subscriptions`;
CREATE TABLE `user_subscriptions` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `plan_id` bigint UNSIGNED NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_user_subscriptions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_subscriptions_plan_id` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `invoice_no` varchar(255) NOT NULL UNIQUE,
    `order_id` bigint UNSIGNED NOT NULL,
    `user_id` bigint UNSIGNED NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `gst` decimal(10,2) NOT NULL,
    `total` decimal(10,2) NOT NULL,
    `payment_status` varchar(255) NOT NULL,
    `pdf_file` varchar(255) NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_invoices_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_invoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE `invoice_items` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` bigint UNSIGNED NOT NULL,
    `description` varchar(255) NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_invoice_items_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `order_id` bigint UNSIGNED NULL DEFAULT NULL,
    `gateway` varchar(255) NOT NULL,
    `transaction_id` varchar(255) NOT NULL UNIQUE,
    `amount` decimal(10,2) NOT NULL,
    `status` varchar(255) NOT NULL,
    `payment_date` datetime NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_payments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_payments_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL UNIQUE,
    `balance` decimal(10,2) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_wallets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `wallet_transactions`;
CREATE TABLE `wallet_transactions` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `wallet_id` bigint UNSIGNED NOT NULL,
    `type` varchar(255) NOT NULL,
    `credit_debit` varchar(255) NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `remark` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_wallet_transactions_wallet_id` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kundalis`;
CREATE TABLE `kundalis` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) NOT NULL,
    `dob` date NOT NULL,
    `birth_time` time NOT NULL,
    `birth_place` varchar(255) NOT NULL,
    `latitude` decimal(10,8) NOT NULL,
    `longitude` decimal(11,8) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_kundalis_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kundali_reports`;
CREATE TABLE `kundali_reports` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kundali_id` bigint UNSIGNED NOT NULL,
    `lagna` varchar(255) NULL DEFAULT NULL,
    `moon_sign` varchar(255) NULL DEFAULT NULL,
    `sun_sign` varchar(255) NULL DEFAULT NULL,
    `nakshatra` varchar(255) NULL DEFAULT NULL,
    `report_json` longtext NULL DEFAULT NULL,
    `pdf_file` varchar(255) NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_kundali_reports_kundali_id` FOREIGN KEY (`kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kundali_planets`;
CREATE TABLE `kundali_planets` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kundali_id` bigint UNSIGNED NOT NULL,
    `planet_name` varchar(255) NOT NULL,
    `sign` varchar(255) NOT NULL,
    `house` int NOT NULL,
    `degree` decimal(5,2) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_kundali_planets_kundali_id` FOREIGN KEY (`kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `doshas`;
CREATE TABLE `doshas` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kundali_id` bigint UNSIGNED NOT NULL,
    `dosha_name` varchar(255) NOT NULL,
    `severity` varchar(255) NOT NULL,
    `remedies` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_doshas_kundali_id` FOREIGN KEY (`kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `yogas`;
CREATE TABLE `yogas` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kundali_id` bigint UNSIGNED NOT NULL,
    `yoga_name` varchar(255) NOT NULL,
    `description` text NULL DEFAULT NULL,
    `benefits` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_yogas_kundali_id` FOREIGN KEY (`kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dashas`;
CREATE TABLE `dashas` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `kundali_id` bigint UNSIGNED NOT NULL,
    `mahadasha` varchar(255) NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `description` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_dashas_kundali_id` FOREIGN KEY (`kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `kundali_matches`;
CREATE TABLE `kundali_matches` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `male_kundali_id` bigint UNSIGNED NOT NULL,
    `female_kundali_id` bigint UNSIGNED NOT NULL,
    `guna_score` decimal(4,2) NOT NULL,
    `report` longtext NULL DEFAULT NULL,
    `pdf_file` varchar(255) NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_kundali_matches_male_kundali_id` FOREIGN KEY (`male_kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_kundali_matches_female_kundali_id` FOREIGN KEY (`female_kundali_id`) REFERENCES `kundalis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `consultations`;
CREATE TABLE `consultations` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `consultation_type` varchar(255) NOT NULL,
    `scheduled_at` datetime NOT NULL,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_consultations_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_consultations_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `chat_rooms`;
CREATE TABLE `chat_rooms` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `consultation_id` bigint UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_chat_rooms_consultation_id` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `room_id` bigint UNSIGNED NOT NULL,
    `sender_id` bigint UNSIGNED NOT NULL,
    `message` longtext NULL DEFAULT NULL,
    `attachment` varchar(255) NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_chat_messages_room_id` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_chat_messages_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `predictions`;
CREATE TABLE `predictions` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `category_id` bigint UNSIGNED NOT NULL,
    `question` longtext NOT NULL,
    `prediction` longtext NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_predictions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_predictions_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_predictions_category_id` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `astrologer_id` bigint UNSIGNED NOT NULL,
    `rating` int NOT NULL,
    `review` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_reviews_astrologer_id` FOREIGN KEY (`astrologer_id`) REFERENCES `astrologers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE `support_tickets` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ticket_no` varchar(255) NOT NULL UNIQUE,
    `user_id` bigint UNSIGNED NOT NULL,
    `subject` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_support_tickets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ticket_replies`;
CREATE TABLE `ticket_replies` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` bigint UNSIGNED NOT NULL,
    `user_id` bigint UNSIGNED NOT NULL,
    `message` text NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_ticket_replies_ticket_id` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_ticket_replies_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `referrals`;
CREATE TABLE `referrals` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `referrer_id` bigint UNSIGNED NOT NULL,
    `referred_user_id` bigint UNSIGNED NOT NULL,
    `reward_amount` decimal(10,2) NOT NULL DEFAULT 0,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_referrals_referrer_id` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_referrals_referred_user_id` FOREIGN KEY (`referred_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `title` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `is_read` tinyint NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_notifications_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category_id` bigint UNSIGNED NULL DEFAULT NULL,
    `title` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL UNIQUE,
    `content` longtext NOT NULL,
    `image` varchar(255) NULL DEFAULT NULL,
    `status` tinyint NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_blogs_category_id` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cms_pages`;
CREATE TABLE `cms_pages` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL UNIQUE,
    `content` longtext NOT NULL,
    `seo_title` varchar(255) NULL DEFAULT NULL,
    `seo_description` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `code` varchar(255) NOT NULL UNIQUE,
    `discount_type` varchar(255) NOT NULL,
    `discount_value` decimal(10,2) NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `status` tinyint NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `seo_settings`;
CREATE TABLE `seo_settings` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `page_name` varchar(255) NOT NULL UNIQUE,
    `meta_title` varchar(255) NULL DEFAULT NULL,
    `meta_description` text NULL DEFAULT NULL,
    `meta_keywords` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `subject` varchar(255) NOT NULL,
    `body` longtext NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sms_templates`;
CREATE TABLE `sms_templates` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `message` text NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category_id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) NOT NULL,
    `price` decimal(10,2) NOT NULL,
    `stock` int NOT NULL DEFAULT 0,
    `image` varchar(255) NULL DEFAULT NULL,
    `description` longtext NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_products_category_id` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `product_orders`;
CREATE TABLE `product_orders` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` bigint UNSIGNED NOT NULL,
    `total_amount` decimal(10,2) NOT NULL,
    `status` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    CONSTRAINT `fk_product_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `setting_key` varchar(255) NOT NULL UNIQUE,
    `setting_value` longtext NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
