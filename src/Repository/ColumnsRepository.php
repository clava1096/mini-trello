<?php

namespace Src\Repository;

use PDO;
use Src\Models\Board;
use Config\Db\Database;
use Src\Models\Column;

class ColumnsRepository implements ColumnsRepositoryInterface{

    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function getColumns(int $boardId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM columns WHERE board_id = ?");
        $stmt->execute([$boardId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $columns = [];
        foreach ($rows as $row) {
            $column = new Column(
                $row['id'],
                $row['board_id'],
                $row['name'],
                $row['position']
            );
        }
        return $columns;
    }

    public function create(Column $column): Column {
        $stmt = $this->pdo->prepare("INSERT INTO columns (board_id, name, position) VALUES (?, ?, ?)");
        $stmt->execute([$column->getBoardId(), $column->getName(), $column->getPosition()]);
        $id = $this->pdo->lastInsertId();
        $column->setId($id);
        return $column;
    }

    public function update(Column $column): bool {
        $stmt = $this->pdo->prepare("UPDATE columns
        SET name = ?, position = ?");
        $stmt->execute([$column->getName(), $column->getPosition()]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $boardId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM columns WHERE board_id = ?");
        $stmt->execute([$boardId]);
        return $stmt->rowCount() > 0;
    }

    public function getAllColumns(int $boardId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM columns WHERE board_id = ?");
        $stmt->execute([$boardId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $columns = [];
        foreach ($rows as $row) {
            $columns[] = new Column(
                $row['id'],
                $row['board_id'],
                $row['name'],
                $row['position']
            );
        }
        return $columns;
    }
}