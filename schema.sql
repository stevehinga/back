CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mac_address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    package VARCHAR(50) NOT NULL,
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP,
    status VARCHAR(50) DEFAULT 'active'
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(20) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_id VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    payment_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
