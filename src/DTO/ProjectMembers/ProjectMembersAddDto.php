<?php

namespace Src\DTO\ProjectMembers;

use InvalidArgumentException;

class ProjectMembersAddDto {
    public function __construct(
        public array $userIds,
    ) {}

    public static function fromJson(string $json): self {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid JSON");
        }

        // Преобразуем userIds в массив чисел, если пришел не массив - создаем массив из одного элемента
        $userIds = $data['userIds'] ?? $data['userId'] ?? [];
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        return new self(
            array_map('intval', $userIds)
        );
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->userIds)) {
            $errors["userIds"] = "At least one user ID is required";
        }

        foreach ($this->userIds as $index => $userId) {
            if ($userId < 1) {
                $errors["userIds_$index"] = "User ID at position $index must be greater than 0";
            }
        }

        return $errors;
    }
}