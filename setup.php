CREATE DATABASE riverrun;
USE riverrun;

CREATE TABLE registrations (
 id INT AUTO_INCREMENT PRIMARY KEY,
 first_name VARCHAR(50),
 last_name VARCHAR(50),
 age INT,
 sex VARCHAR(10),
 dob DATE,
 event VARCHAR(10),
 address VARCHAR(255),
 email VARCHAR(100),
 shirt VARCHAR(5),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
