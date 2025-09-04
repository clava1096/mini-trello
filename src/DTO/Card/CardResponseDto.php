<?php

namespace Src\DTO\Card;
class CardResponseDto {
    public function __construct(
        public int $id,
        public int $columnId,
        public string $title,
        public ?string $description,
        public int $position,
        public int $createdBy
    ) {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'columnId' => $this->columnId,
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'createdBy' => $this->createdBy
        ];
    }
}