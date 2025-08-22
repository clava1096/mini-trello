<?php

require_once __DIR__ . "/../../config/db/Db.php";

use Config\Db\Database;

$pdo = Database::getConnection();

$sql = "CREATE TABLE IF NOT EXISTS cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    column_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    position INT DEFAULT 0,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (column_id) REFERENCES columns(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
)";

$pdo->exec($sql);

echo "Table cards created\n";