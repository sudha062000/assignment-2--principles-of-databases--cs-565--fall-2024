CREATE TABLE macos-support (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model_name VARCHAR(255) NOT NULL,
    installed_os VARCHAR(255) NOT NULL,
    last_supported_os VARCHAR(255) NOT NULL
);
