CREATE USER 'api'@'%' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON `tranquillo`.* TO 'api'@'%';