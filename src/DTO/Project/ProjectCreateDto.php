<?php

namespace Src\DTO\Project;

use InvalidArgumentException;

class ProjectCreateDto{
    public function __construct(
        public string $name,
        public string $description,
        public int $ownerId,
    )
    {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["name"] ?? null,
            $data["description"] ?? null,
            $data["ownerId"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->name)) {
            $errors["name"] = "Name cannot be empty";
        }
        if ($this->ownerId < 0 || $this->ownerId == null) {
            $errors["ownerId"] = "Owner id cannot be negative or null";
        }

        return $errors;
    }
}