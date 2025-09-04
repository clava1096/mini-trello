<?php

namespace Src\DTO\Column;
use InvalidArgumentException;

class CreateColumnDto {
    public function __construct(
        public int $id,
        public int $boardId,
        public string $name,
        public ?int $position = 0
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data['id'],
            $data["boardId"] ?? throw new InvalidArgumentException("boardId is required"),
            $data["name"] ?? throw new InvalidArgumentException("name is required"),
            $data["position"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->name)) {
            $errors["name"] = "Name cannot be empty";
        }

        if ($this->boardId <= 0) {
            $errors["boardId"] = "Invalid board ID";
        }

        if ($this->position !== null && $this->position < 0) {
            $errors["position"] = "Position cannot be negative";
        }

        return $errors;
    }
}