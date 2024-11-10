\W -- Enable all warnings

DROP DATABASE IF EXISTS `computer_inventory`;
CREATE DATABASE IF NOT EXISTS `computer_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE USER IF NOT EXISTS 'computer_inventory_manager'@'localhost' IDENTIFIED BY 'b(79yKo8Ei';
GRANT ALL PRIVILEGES ON computer_inventory.* TO 'computer_inventory_manager'@'localhost';

USE computer_inventory;
source create-macosversion-table.sql;
source create-macos_support-table.sql;
source create-macosmodel-table.sql;
source create-versionyear-table.sql;
source populate-macos_support-table.sql;
source populate-macosmodel-table.sql;
source populate-macosversion-table.sql;
source populate-versionyear-table.sql;