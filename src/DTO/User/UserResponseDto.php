<?php
namespace Src\DTO\User;

class UserResponseDto {
    public function __construct(
        public int $id,
        public string $name,
        public string $email
    ) {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}