<?php

require_once __DIR__ . "/../../config/db/Db.php";

use Config\Db\Database;

$pdo = Database::getConnection();

$sql = "CREATE TABLE IF NOT EXISTS columns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    position INT DEFAULT 0,
    FOREIGN KEY (board_id) REFERENCES boards(id) ON DELETE CASCADE)";

$pdo->exec($sql);

echo "Table columns created\n";
