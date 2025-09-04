<?php

namespace Src\DTO\Board;

class CreateBoardDto {
    public function __construct(
        public int $projectId,
        public string $getName,
    )
    {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["projectId"] ?? null,
            $data["name"] ?? null,
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->getName)) {
            $errors["name"] = "Name cannot be empty";
        }

        return $errors;
    }
}