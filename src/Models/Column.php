<?php

namespace Src\Models;

class Column {
    private int $id;
    private int $boardId;

    private string $name;

    private int $position;
    public function __construct(int $id, int $boardId, string $name, int $position) {
        $this->id = $id;
        $this->boardId = $boardId;
        $this->name = $name;
        $this->position = $position;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBoardId(): int
    {
        return $this->boardId;
    }

    public function setBoardId(int $boardId): void
    {
        $this->boardId = $boardId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

}