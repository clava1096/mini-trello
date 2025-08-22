<?php

namespace Src\Repository;

use Src\Models\Board;

interface BoardsRepositoryInterface {
    public function create(Board $board): Board;
    public function update(Board $board): bool;

    public function delete(int $boardId): bool;

    public function getAllByProjectId(int $projectId): array;

    public function getBoardById(int $boardId): ?Board;
}