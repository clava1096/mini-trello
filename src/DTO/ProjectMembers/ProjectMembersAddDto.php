<?php

namespace Src\DTO\ProjectMembers;

use InvalidArgumentException;

class ProjectMembersAddDto {
    public function __construct(
        public int $projectId,
        public int $userId,
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data['$projectId'] ?? 0,
            $data['$userId'] ?? 0,
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->projectId < 1) {
            $errors["projectId"] = "Project id must be greater than 0";
        }

        if ($this->userId < 1) {
            $errors["userId"] = "User id must be greater than 0";
        }

        return $errors;
    }
}