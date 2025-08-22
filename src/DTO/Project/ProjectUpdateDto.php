<?php

namespace Src\DTO\Project;

use InvalidArgumentException;

class ProjectUpdateDto {
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
    )
    {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data['id'],
            $data["name"] ?? null,
            $data["description"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->id < 0 ) {
            $errors["id"] = "id must be greater zero!";
        }

        if (empty($this->name)) {
            $errors["name"] = "Name cannot be empty";
        }

        return $errors;
    }
}