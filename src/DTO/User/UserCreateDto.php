<?php

namespace Src\DTO\User;

use InvalidArgumentException;

class UserCreateDto {
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON');
        }

        return new self(
            $data['username'] ?? null,
            $data['email'] ?? null,
            $data['password'] ?? null
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->username)) {
            $errors[] = "Имя не может быть пустым";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Некорректный email";
        }
        if (strlen($this->password) < 6) {
            $errors[] = "Пароль должен быть не меньше 6 символов";
        }

        return $errors;
    }
}