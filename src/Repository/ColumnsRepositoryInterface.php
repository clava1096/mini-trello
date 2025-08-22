<?php

namespace Src\Repository;

use Src\Models\Column;

interface ColumnsRepositoryInterface {
    public function getColumns(int $boardId): array;

    public function create(Column $column): Column;

    public function update(Column $column): bool;

    public function delete(int $boardId): bool;
}