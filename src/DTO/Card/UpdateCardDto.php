<?php

namespace Src\DTO\Card;
use InvalidArgumentException;

class UpdateCardDto {
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?int $columnId = null,
        public ?int $position = null
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["title"] ?? null,
            $data["description"] ?? null,
            $data["columnId"] ?? null,
            $data["position"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->title !== null && empty($this->title)) {
            $errors["title"] = "Title cannot be empty";
        }

        if ($this->columnId !== null && $this->columnId <= 0) {
            $errors["columnId"] = "Invalid column ID";
        }

        if ($this->position !== null && $this->position < 0) {
            $errors["position"] = "Position cannot be negative";
        }

        return $errors;
    }
}