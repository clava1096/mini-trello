<?php

namespace Src\Repository;

use Src\Models\Card;

interface CardsRepositoryInterface {

    public function create(Card $card): Card;

    public function getAllCards(int $columnId): array;

    public function getCard(int $cardId): Card;
    public function update(Card $card): bool;

    public function delete(int $id): bool;

}