<?php

namespace Src\Models;

class Comment {
    private int $id;

    private int $cardId;

    private int $userId;

    private string $content;

    private string $createdAt;

    public function __construct(int $id, int $cardId, int $userId, string $content, string $createdAt)
    {
        $this->id = $id;
        $this->cardId = $cardId;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCardId(): int
    {
        return $this->cardId;
    }

    public function setCardId(int $cardId): void
    {
        $this->cardId = $cardId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}