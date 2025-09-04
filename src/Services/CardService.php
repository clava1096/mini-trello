<?php

namespace Src\Services;

use Src\DTO\Card\CreateCardDto;
use Src\DTO\Card\UpdateCardDto;
use Src\Models\Card;
use Src\Repository\BoardsRepository;
use Src\Repository\CardsRepository;

class CardService {

    /*
     📝 Cards
    POST /api/columns/:id/cards – создать карточку в колонке
    { "title": "Fix bug", "description": "…" }
    GET /api/columns/:id/cards – список карточек в колонке
    GET /api/cards/:id – получить карточку
    PUT /api/cards/:id – обновить карточку (title, description, column_id, position)
    DELETE /api/cards/:id – удалить карточку
     */

    private CardsRepository $cardsRepository;

    public function __construct() {
        $this->cardsRepository = new CardsRepository();
    }

    public function createCard(CreateCardDto $dto, int $createdBy): Card {
        $card = new Card(
            0,
            $dto->columnId,
            $dto->title,
            $dto->description,
            0, // position
            $createdBy,
            time()
        );

        return $this->cardsRepository->create($card);
    }

    public function getCardsByColumnId(int $columnId): array {
        return $this->cardsRepository->getAllCards($columnId);
    }

    public function getCardById(int $cardId): Card {
        $card = $this->cardsRepository->getCard($cardId);
        if (!$card) {
            throw new Exception("Card not found");
        }
        return $card;
    }
    public function updateCard(int $cardId, UpdateCardDto $dto): Card {

        $card = $this->getCardById($cardId);
        $card->setTitle($dto->title);
        $card->setDescription($dto->description);
        $card->setColumnId($dto->columnId);
        $card->setPosition($dto->position);

        return $card;

    }

    public function deleteCard(int $cardId): bool {
        return $this->cardsRepository->delete($cardId);
    }

}