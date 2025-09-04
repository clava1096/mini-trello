<?php

namespace Src\Controllers;

use Src\DTO\Column\ColumnResponseDto;
use Src\DTO\Column\CreateColumnDto;
use Src\Services\ColumnService;
use Src\DTO\Column\UpdateColumnDto;

class ColumnController {
    private ColumnService $columnService;

    public function __construct() {
        $this->columnService = new ColumnService();
    }

    public function createColumn(CreateColumnDto $dto): array {
        $column = $this->columnService->createColumn($dto);
        return (new ColumnResponseDto(
            $column->getId(),
            $column->getBoardId(),
            $column->getName(),
            $column->getPosition()
        ))->toArray();
    }

    public function getColumns(int $boardId): array {
        $columns = $this->columnService->getColumnsByBoardId($boardId);

        return array_map(function($column) {
            return (new ColumnResponseDto(
                $column->getId(),
                $column->getBoardId(),
                $column->getName(),
                $column->getPosition()
            ))->toArray();
        }, $columns);
    }

    public function getColumn(int $id): array {
        $column = $this->columnService->getColumnById($id);
        return (new ColumnResponseDto(
            $column->getId(),
            $column->getBoardId(),
            $column->getName(),
            $column->getPosition()
        ))->toArray();
    }

    public function updateColumn(int $id, UpdateColumnDto $dto): array {
        $column = $this->columnService->updateColumn($id, $dto);
        return (new ColumnResponseDto(
            $column->getId(),
            $column->getBoardId(),
            $column->getName(),
            $column->getPosition()
        ))->toArray();
    }

    public function deleteColumn(int $id): array {
        $result = $this->columnService->deleteColumn($id);

        return [
            'success' => $result,
            'message' => $result ? 'Column successfully deleted' : 'Column not found',
            'deletedId' => $id
        ];
    }
}