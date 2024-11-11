
CREATE TABLE macosmodel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model_name VARCHAR(255) NOT NULL,
    model_identifier VARCHAR(50) NOT NULL,
    model_number VARCHAR(50) ,
    part_number VARCHAR(50) NOT NULL,
    serial_number VARCHAR(50) NOT NULL,
    darwin_os_number INT NOT NULL,
    latest_supporting_darwin_os_number INT NOT NULL,
    url VARCHAR(255) NOT NULL
);
