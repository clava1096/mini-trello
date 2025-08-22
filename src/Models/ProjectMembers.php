<?php

namespace Src\Models;

class ProjectMembers {
    private int $id;
    private int $projectId;

    private int $userId;

    private int $createdAt;

    public function __construct(int $id, int $projectId, int $userId, int $createdAt) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->userId = $userId;
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

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
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