<?php

namespace Src\DTO\Board;

class BoardResponseDto {
    public function __construct(
        public int $id,
        public int $projectId,
        public string $name,
    ) {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'projectId' => $this->projectId,
            'name' => $this->name,
        ];
    }
}