<?php

namespace Src\Models;

class Project {
    private int $id;

    private string $name;

    private string $description;

    private int $ownerId;

    private int $createdAt;

    public function __construct(int $id, string $name, string $description, int $ownerId, int $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->ownerId = $ownerId;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
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