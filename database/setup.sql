\W -- Enable all warnings

DROP DATABASE IF EXISTS `computer_inventory`;
CREATE DATABASE IF NOT EXISTS `computer_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE USER IF NOT EXISTS 'computer_inventory_manager'@'localhost' IDENTIFIED BY 'b(79yKo8Ei';
GRANT ALL PRIVILEGES ON computer_inventory.* TO 'computer_inventory_manager'@'localhost';

USE computer_inventory;

SOURCE create-macos_dates-table.sql;
SOURCE create-macos_id-table.sql;
SOURCE create-macos_model-table.sql;
SOURCE create-macos_version-table.sql;

SOURCE populate-macos_dates-table.sql;
SOURCE populate-macos_id-table.sql;
SOURCE populate-macos_model-table.sql;
SOURCE populate-macos_version-table.sql;
