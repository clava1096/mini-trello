<?php

namespace Src\DTO\Column;
class UpdateColumnDto {
    public function __construct(
        public ?string $name = null,
        public ?int $position = null
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["name"] ?? null,
            $data["position"] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if ($this->name !== null && empty($this->name)) {
            $errors["name"] = "Name cannot be empty";
        }

        if ($this->position !== null && $this->position < 0) {
            $errors["position"] = "Position cannot be negative";
        }

        return $errors;
    }
}