CREATE DATABASE IF NOT EXISTS cad_vvf;
USE cad_vvf;

CREATE TABLE protocols (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    protocol_id INT NOT NULL,
    text VARCHAR(255) NOT NULL,
    type ENUM('yesno','choice') DEFAULT 'yesno',
    next_if_yes INT DEFAULT NULL,
    next_if_no INT DEFAULT NULL,
    FOREIGN KEY (protocol_id) REFERENCES protocols(id)
);

CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    call_id INT NOT NULL,
    question_id INT NOT NULL,
    answer VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE call_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    caller_number VARCHAR(20) NOT NULL,
    protocol_id INT NOT NULL,
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP NULL,
    final_severity VARCHAR(50) DEFAULT NULL,
    notes TEXT,
    FOREIGN KEY (protocol_id) REFERENCES protocols(id)
);