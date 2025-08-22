<?php

namespace Src\Repository;

use PDO;
use Src\Models\Comment;
use Config\Db\Database;

class CommentsRepository implements CommentsRepositoryInterface {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(Comment $comment): Comment {
        $stmt = $this->pdo->prepare("INSERT INTO comments (card_id, user_id, content) VALUES (:card_id, :user_id, :content)");
        $stmt->execute(["card_id" => $comment->getCardId(),
              "user_id" => $comment->getUserId(),
              "content" => $comment->getContent()]);
        $comment->setId($this->pdo->lastInsertId());
        return $comment;
    }

    public function getAllComments(int $cardId): array {
        $stmt = $this->pdo->prepare("
        SELECT * FROM comments 
        WHERE card_id = :card_id 
        ORDER BY created_at DESC
    ");

        $stmt->execute(['card_id' => $cardId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];

        foreach($rows as $row) {
            $comments[] = new Comment(
                $row['id'],
                $row['card_id'],
                $row['user_id'],
                $row['content'],
                $row['created_at']
            );
        }

        return $comments;
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}