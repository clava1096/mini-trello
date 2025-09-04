<?php

namespace Src\Repository;

use Config\Db\Database;
use PDO;
use Src\Models\Board;


class BoardsRepository implements BoardsRepositoryInterface{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function create(Board $board): Board
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO boards (name, project_id) VALUES (:name, :project_id)");
        $stmt->execute([
            "name" => $board->getName(),
            "project_id" => $board->getProjectId()
        ]);
        $id = (int)$this->pdo->lastInsertId();
        $board->setId($id);
        return $board;
    }

    public function update(Board $board): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE boards 
            SET name = :name,
                project_id = :project_id
            WHERE id = :id"
        );
        $stmt->execute([
            "name" => $board->getName(),
            "project_id" => $board->getProjectId(),
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $boardId): bool
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM boards WHERE id = :id"
        );
        $stmt->execute([
            "id" => $boardId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getAllByProjectId(int $projectId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM boards WHERE project_id = :project_id");
        $stmt->execute([
            "project_id" => $projectId
        ]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $boards = [];
        foreach ($rows as $row) {
            $boards[] = new Board(
                $row['id'],
                $row['project_id'],
                $row['name']
            );
        }
        return $boards;
    }

    public function getBoardById(int $boardId): ?Board
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM boards WHERE id = :id"
        );
        $stmt->execute([
            "id" => $boardId
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Board($row['id'], $row['project_id'], $row['name']);
        }
        return null;
    }
}