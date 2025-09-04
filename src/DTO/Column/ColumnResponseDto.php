<?php

namespace Src\DTO\Column;
class ColumnResponseDto {
    public function __construct(
        public int $id,
        public int $boardId,
        public string $name,
        public int $position
    ) {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'boardId' => $this->boardId,
            'name' => $this->name,
            'position' => $this->position
        ];
    }
}