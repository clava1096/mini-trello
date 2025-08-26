<?php

namespace Src\DTO\Project;

class ProjectResponseDto {

    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $ownerId,
    )
    {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'ownerId' => $this->ownerId,
        ];
    }

}