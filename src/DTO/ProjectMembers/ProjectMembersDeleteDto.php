<?php

namespace Src\DTO\ProjectMembers;

use InvalidArgumentException;

class ProjectMembersDeleteDto {
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
            (int)($data['projectId'] ?? throw new InvalidArgumentException("projectId is required")),
            (int)($data['userId'] ?? throw new InvalidArgumentException("userId is required"))
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->projectId < 1) {
            $errors["projectId"] = "Project ID must be greater than 0";
        }

        if ($this->userId < 1) {
            $errors["userId"] = "User ID must be greater than 0";
        }

        return $errors;
    }
}