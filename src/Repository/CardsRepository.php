<?php

namespace Src\Repository;

use PDO;
use Src\Models\Card;
use Config\Db\Database;
class CardsRepository implements CardsRepositoryInterface {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }


    public function create(Card $card): Card
    {
        $stmt = $this->pdo->prepare("INSERT INTO cards (column_id, title, description, created_by)
                VALUES (:column_id, :title, :description, :created_by)");
        $stmt->execute([
            "column_id" => $card->getColumnId(),
            "title" => $card->getTitle(),
            "description" => $card->getDescription(),
            "created_by" => $card->getCreatedBy()
        ]);
        $id = (int)$this->pdo->lastInsertId();
        $card->setId($id);
        $card->setPosition(0);
        $card->setCreatedAt(time());
        return $card;
    }

    public function getAllCards(int $columnId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cards WHERE column_id = ?");
        $stmt->execute([$columnId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cards = [];

        foreach($rows as $row) {
            $cards[] = new Card(
                $row['id'],
                $row['column_id'],
                $row['title'],
                $row['description'],
                $row['position'],
                $row['created_by'],
                $row['created_at']
            );
        }
        return $cards;
    }

    public function getCard(int $cardId): Card
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cards WHERE id = ?");
        $stmt->execute([$cardId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Card($row['id'], $row['column_id'], $row['title'], $row['description'], $row['position'], $row['created_by'], $row['created_at']);
    }

    public function update(Card $card): bool
    {
        $stmt = $this->pdo->prepare("UPDATE cards
        SET column_id = :column_id,
            title = :title,
            description = :description,
            position = :position
            WHERE id = :id");
        $stmt->execute([
            "column_id" => $card->getColumnId(),
            "title" => $card->getTitle(),
            "description" => $card->getDescription(),
            "position" => $card->getPosition(),
            "id" => $card->getId()
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM cards WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}