SET
    NAMES utf8;

SET
    time_zone = `+00:00`;

SET
    foreign_key_checks = 0;

SET
    NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS tranquillo
/*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE tranquillo;

DROP TABLE IF EXISTS tpa_subtasks,
tpa_tasks,
tpa_users,
tpa_roles;

CREATE TABLE
    IF NOT EXISTS tpa_users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(180) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        firstname VARCHAR(50) NOT NULL,
        user_password VARCHAR(255) NOT NULL,
        user_role VARCHAR(255) NULL,
        user_create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT tpa_users_ukey UNIQUE (email),
        INDEX tpa_users_email_ikey (email),
        INDEX tpa_users_lastname_ikey (lastname),
        INDEX tpa_users_firstname_ikey (firstname),
        INDEX tpa_users_create_at_ikey (user_create_at)
    );

CREATE TABLE
    IF NOT EXISTS tpa_tasks (
        task_id INT AUTO_INCREMENT PRIMARY KEY,
        task_name VARCHAR(50) NOT NULL,
        task_description TEXT,
        task_reminder INT DEFAULT NULL,
        task_start_at DATETIME NULL,
        task_end_at DATETIME NULL,
        task_create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        users_id INT NOT NULL,
        CONSTRAINT tpa_tasks_users_fkey FOREIGN KEY (users_id) REFERENCES tpa_users (user_id),
        CONSTRAINT tpa_tasks_ukey UNIQUE (task_name, task_create_at),
        INDEX tpa_tasks_name_ikey (task_name),
        INDEX tpa_tasks_create_at_ikey (task_create_at)
    );

CREATE TABLE
    IF NOT EXISTS tpa_subtasks (
        subtask_id INT AUTO_INCREMENT PRIMARY KEY,
        subtask_name VARCHAR(50) NOT NULL,
        subtask_create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        subtask_order INT NULL,
        is_finished INT NOT NULL,
        tasks_id INT NOT NULL,
        CONSTRAINT tpa_subtasks_tasks_fkey FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (task_id),
        CONSTRAINT tpa_subtasks_ukey UNIQUE (subtask_name, subtask_create_at),
        INDEX tpa_subtasks_name_ikey (subtask_name),
        INDEX tpa_subtasks_create_at_ikey (subtask_create_at)
    );