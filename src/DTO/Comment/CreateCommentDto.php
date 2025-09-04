<?php

namespace Src\DTO\Comment;
class CreateCommentDto {
    public function __construct(
        public int $cardId,
        public string $content
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        return new self(
            $data["cardId"] ?? throw new InvalidArgumentException("cardId is required"),
            $data["content"] ?? throw new InvalidArgumentException("content is required")
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->content)) {
            $errors["content"] = "Content cannot be empty";
        }

        if ($this->cardId <= 0) {
            $errors["cardId"] = "Invalid card ID";
        }

        return $errors;
    }
}