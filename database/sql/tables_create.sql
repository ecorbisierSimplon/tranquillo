SET
    NAMES utf8;

SET
    time_zone = `+00:00`;

SET
    foreign_key_checks = 0;

SET
    NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS tranquillo /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE tranquillo;

DROP TABLE IF EXISTS 
    tpa_users, tpa_roles, tpa_tasks, tpa_understains, tpa_tohave;
    
CREATE TABLE
    IF NOT EXISTS tpa_users (
        id int AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        lastname varchar(50) NOT NULL,
        firstname varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        roles_code int NOT NULL,
        CONSTRAINT tpa_users_pkey PRIMARY KEY (id),
        CONSTRAINT tpa_users_ukey UNIQUE (email),
        CONSTRAINT tpa_users_tpa_roles_fkey 
            FOREIGN KEY (roles_code) 
            REFERENCES tpa_roles (code)
    );

CREATE TABLE
    IF NOT EXISTS tpa_roles (
        code int (11),
        `name` varchar(50) NOT NULL,
        CONSTRAINT tpa_roles_pkey PRIMARY KEY (code),
        CONSTRAINT tpa_roles_code_ukey UNIQUE (`name`)
    );

CREATE TABLE
    IF NOT EXISTS tpa_tasks (
        id int AUTO_INCREMENT,
        datetime_create datetime NOT NULL ON UPDATE current_timestamp(),
        `name` varchar(50) NOT NULL,
        `description` text DEFAULT NULL,
        `repeat` int (11) DEFAULT NULL,
        datetime_start datetime DEFAULT NULL,
        datetime_end datetime DEFAULT NULL,
        users_id int NOT NULL,
        CONSTRAINT tpa_tasks_pkey PRIMARY KEY (id),
        CONSTRAINT tpa_users_tpa_task_fkey 
            FOREIGN KEY (users_id) 
            REFERENCES tpa_users (id)
    );

CREATE TABLE
    IF NOT EXISTS tpa_understains (
        id int AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `order` int (11) NOT NULL,
        is_finished int (2) NOT NULL,
        datetime_create datetime NOT NULL ON UPDATE current_timestamp(),
        tasks_id int NOT NULL,
        CONSTRAINT tpa_understains_pkey PRIMARY KEY (id),
        CONSTRAINT tpa_tasks_tpa_understains_fkey 
            FOREIGN KEY (tasks_id) 
            REFERENCES tpa_tasks (id)
    );

CREATE TABLE
    IF NOT EXISTS tpa_tohave (
        id int AUTO_INCREMENT,
        users_id INT,
        roles_code INT,
        CONSTRAINT tpa_tohave_pkey PRIMARY KEY (id),
        CONSTRAINT tpa_tohave_users_roles_ukey UNIQUE (users_id, roles_code),        
        CONSTRAINT tpa_tohave_tpa_users_fkey 
            FOREIGN KEY (users_id) 
            REFERENCES tpa_users (id),
        CONSTRAINT tpa_tohave_tpa_roles_fkey 
            FOREIGN KEY (roles_code) 
            REFERENCES tpa_roles (code)
    );

INSERT INTO
    `tpa_roles` (`code`, `name`)
VALUES
    ('100', 'webmaster'),
    ('90', 'admin'),
    ('1', 'visiteur'),
    ('10', 'inscrit'),
    ('20', 'utilisateur');

INSERT INTO
    `tpa_users` (
        `id`,
        `email`,
        `lastname`,
        `firstname`,
        `password`,
        `roles_code`
    )
VALUES
    (
        '1',
        'emploi@corbisier.fr',
        'CORBISIER',
        'Eric',
        '1234',
        '100'
    );

INSERT INTO
    `tpa_tohave` (
        `users_id`,
        `roles_code`
    )
VALUES
    (
        '1',
        '100'
    );