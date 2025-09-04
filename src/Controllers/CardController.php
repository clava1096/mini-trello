<?php

namespace Src\Controllers;

use Src\DTO\Card\CardResponseDto;
use Src\DTO\Card\CreateCardDto;
use Src\DTO\Card\UpdateCardDto;
use Src\Services\CardService;

class CardController {
    private CardService $cardService;

    public function __construct() {
        $this->cardService = new CardService();
    }

    public function createCard(CreateCardDto $dto, int $userId): array {
        $card = $this->cardService->createCard($dto, $userId);
        return (new CardResponseDto(
            $card->getId(),
            $card->getColumnId(),
            $card->getTitle(),
            $card->getDescription(),
            $card->getPosition(),
            $card->getCreatedBy()
        ))->toArray();
    }

    public function getCards(int $columnId): array {
        $cards = $this->cardService->getCardsByColumnId($columnId);

        return array_map(function($card) {
            return (new CardResponseDto(
                $card->getId(),
                $card->getColumnId(),
                $card->getTitle(),
                $card->getDescription(),
                $card->getPosition(),
                $card->getCreatedBy(),
            ))->toArray();
        }, $cards);
    }

    public function getCard(int $id): array {
        $card = $this->cardService->getCardById($id);
        return (new CardResponseDto(
            $card->getId(),
            $card->getColumnId(),
            $card->getTitle(),
            $card->getDescription(),
            $card->getPosition(),
            $card->getCreatedBy(),
        ))->toArray();
    }

    public function updateCard(int $id, UpdateCardDto $dto): array {

        $card = $this->cardService->updateCard($id, $dto);
        return (new CardResponseDto(
            $card->getId(),
            $card->getColumnId(),
            $card->getTitle(),
            $card->getDescription(),
            $card->getPosition(),
            $card->getCreatedBy()
        ))->toArray();
    }

    public function deleteCard(int $id): array {
        $result = $this->cardService->deleteCard($id);

        return [
            'success' => $result,
            'message' => $result ? 'Card successfully deleted' : 'Card not found',
            'deletedId' => $id
        ];
    }
}