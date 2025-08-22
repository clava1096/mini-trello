<?php

require_once __DIR__ . "/../../config/db/Db.php";

use Config\Db\Database;

$pdo = Database::getConnection();


$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
    ";

$pdo->exec($sql);

echo "Users table has been created\n";