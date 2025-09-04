<?php

namespace Src\DTO\Board;

class UpdateBoardDto {
    public function __construct(
        public ?string $name = null
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["name"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->name !== null && empty($this->name)) {
            $errors["name"] = "Name cannot be empty";
        }

        return $errors;
    }
}