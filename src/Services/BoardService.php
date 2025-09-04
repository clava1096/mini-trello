<?php

namespace Src\Services;

use src\DTO\Board\CreateBoardDto;
use src\DTO\Board\UpdateBoardDto;
use Src\Models\Board;
use Src\Repository\BoardsRepository;

class BoardService {
    /*
    📋 Boards
    POST /api/projects/:id/boards – создать доску в проекте
    GET /api/projects/:id/boards – список досок проекта
    GET /api/boards/:id – получить доску по id
    PUT /api/boards/:id – обновить доску (название)
    DELETE /api/boards/:id – удалить доску

    */
    private BoardsRepository $boardsRepository;

    public function __construct() {
        $this->boardsRepository = new BoardsRepository();
    }

    public function createBoardOnProject(CreateBoardDto $dto) : Board {
        $board = new Board(0, $dto->projectId, $dto->getName, time());
        return $this->boardsRepository->create($board);
    }

    public function getAllBoards(int $projectId) : array {
        return $this->boardsRepository->getAllByProjectId($projectId);
    }

    public function getBoard(int $boardId) : ?Board {
        return $this->boardsRepository->getBoardById($boardId);
    }

    public function updateBoard(int $boardId, UpdateBoardDto $dto): ?Board {
        $board = $this->boardsRepository->getBoardById($boardId);
        $board->setName($dto->name);
        return $this->boardsRepository->update($board) ? $board : null;
    }

    public function deleteBoard(int $boardId) : bool {
        return $this->boardsRepository->delete($boardId);
    }

}