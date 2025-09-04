<?php

namespace Src\Services;

use Exception;
use Src\DTO\Column\CreateColumnDto;
use Src\Models\Column;
use Src\Repository\ColumnsRepository;
use Src\DTO\Column\UpdateColumnDto;

class ColumnService {
    /*
    🗂 Columns
    POST /api/boards/:id/columns – создать колонку в доске
    GET /api/boards/:id/columns – список колонок в доске
    PUT /api/columns/:id – обновить колонку (название, position)
    DELETE /api/columns/:id – удалить колонку
    */

    private ColumnsRepository $columnsRepository;

    public function __construct() {
        $this->columnsRepository = new ColumnsRepository();
    }

    public function createColumn(CreateColumnDto $dto): Column {
        $column = new Column(
            $dto->boardId,
            $dto->name,
            $dto->position ?? 0
        );

        return $this->columnsRepository->create($column);
    }

    public function getColumnsByBoardId(int $boardId): array {
        return $this->columnsRepository->getAllColumns($boardId);
    }

    public function getColumnById(int $columnId): Column {
        $column = $this->columnsRepository->getColumn($columnId);
        if (!$column) {
            throw new Exception("Column not found");
        }
        return $column;
    }

    public function updateColumn(int $columnId, UpdateColumnDto $dto): Column {
        $column = $this->getColumnById($columnId);

        if ($dto->name !== null) {
            $column->setName($dto->name);
        }

        if ($dto->position !== null) {
            $column->setPosition($dto->position);
        }

        if ($this->columnsRepository->update($column)) {
            return $column;
        }

        throw new Exception("Failed to update column");
    }

    public function deleteColumn(int $columnId): bool {
        return $this->columnsRepository->delete($columnId);
    }

}