<?php

namespace Src\DTO\Comment;
class CommentResponseDto {
    public function __construct(
        public int $id,
        public int $cardId,
        public int $userId,
        public string $content,
        public int $createdAt
    ) {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'cardId' => $this->cardId,
            'userId' => $this->userId,
            'content' => $this->content,
            'createdAt' => $this->createdAt
        ];
    }
}