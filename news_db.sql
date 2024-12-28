CREATE DATABASE news_db;

USE news_db;

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    url VARCHAR(255),
    published_at DATETIME
);
