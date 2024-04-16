-- Adminer 4.8.1 MySQL 11.3.2-MariaDB-1:11.3.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


SET NAMES utf8mb4;

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `tpa_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` varchar(50) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tpa_roles_code_ukey` (`role_code`),
  UNIQUE KEY `tpa_roles_name_ukey` (`role_name`),
  KEY `tpa_roles_code_ikey` (`role_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `tpa_subtasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasks_id` int(11) NOT NULL,
  `subtask_name` varchar(100) NOT NULL,
  `subtask_create_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `subtask_order` int(11) DEFAULT NULL,
  `subtask_is_finished` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tpa_subtasks_name_create_at_ukey` (`subtask_name`,`subtask_create_at`),
  KEY `tpa_subtasks_name_ikey` (`subtask_name`),
  KEY `tpa_subtasks_create_at_ikey` (`subtask_create_at`),
  KEY `tpa_tasks_id_substask_ikey` (`tasks_id`),
  CONSTRAINT `FK_7EBC9ADAE3272D31` FOREIGN KEY (`tasks_id`) REFERENCES `tpa_tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `tpa_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `task_create_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `task_description` longtext NOT NULL,
  `task_reminder` int(11) DEFAULT NULL,
  `task_start_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `task_end_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tpa_tasks_ukey` (`task_name`,`task_create_at`),
  KEY `tpa_users_id_tasks_ikey` (`users_id`),
  KEY `tpa_tasks_name_ikey` (`task_name`),
  KEY `tpa_tasks_create_at_ikey` (`task_create_at`),
  CONSTRAINT `FK_A175781E67B3B43D` FOREIGN KEY (`users_id`) REFERENCES `tpa_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `tpa_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_id` int(11) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_create_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tpa_users_email_ukey` (`email`),
  KEY `tpa_users_email_ikey` (`email`),
  KEY `tpa_roles_id_users_ikey` (`roles_id`),
  KEY `tpa_users_create_at_ikey` (`user_create_at`),
  CONSTRAINT `FK_E5AEB86038C751C4` FOREIGN KEY (`roles_id`) REFERENCES `tpa_roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2024-04-16 22:10:45
