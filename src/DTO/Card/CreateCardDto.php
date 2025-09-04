<?php

namespace Src\DTO\Card;

use InvalidArgumentException;

class CreateCardDto {
    public function __construct(
        public int $columnId,
        public string $title,
        public ?string $description = null
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["columnId"] ?? throw new InvalidArgumentException("columnId is required"),
            $data["title"] ?? throw new InvalidArgumentException("title is required"),
            $data["description"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->title)) {
            $errors["title"] = "Title cannot be empty";
        }

        if ($this->columnId <= 0) {
            $errors["columnId"] = "Invalid column ID";
        }

        return $errors;
    }
}