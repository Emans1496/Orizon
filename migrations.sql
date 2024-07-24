CREATE DATABASE IF NOT EXISTS orizon_travel;
USE orizon_travel;

CREATE TABLE IF NOT EXISTS countries (
    id VARCHAR(6) PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    countries VARCHAR(255) NOT NULL,
    available_spots INT NOT NULL
);
