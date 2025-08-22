<?php

require_once __DIR__ . "/../../config/db/Db.php";

use Config\Db\Database;

$pdo = Database::getConnection();

$sql = "CREATE TABLE IF NOT EXISTS projects_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_member (project_id, user_id))";

$pdo->exec($sql);

echo "Table projects_members created!\n";