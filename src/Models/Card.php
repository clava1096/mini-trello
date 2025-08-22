<?php

namespace Src\Models;

class Card {
    private int $id;
    private int $columnId;

    private string $title;

    private string $description;

    private int $position;

    private int $createdBy;

    private int $createdAt;

    public function __construct(int $id, int $columnId, string $title, string $description, int $position, int $createdBy, int $createdAt)
    {
        $this->id = $id;
        $this->columnId = $columnId;
        $this->title = $title;
        $this->description = $description;
        $this->position = $position;
        $this->createdBy = $createdBy;
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

    public function getColumnId(): int
    {
        return $this->columnId;
    }

    public function setColumnId(int $columnId): void
    {
        $this->columnId = $columnId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}