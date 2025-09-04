<?php

namespace Src\Controllers;

use Exception;
use Src\DTO\Board\BoardResponseDto;
use Src\DTO\Board\CreateBoardDto;
use Src\DTO\Board\UpdateBoardDto;
use Src\Services\BoardService;
use Src\Services\ProjectService;
use Src\Services\UserService;

class BoardController {
    private BoardService $boardService;
    private UserService $userService;
    private ProjectService $projectService;

    public function __construct() {
        $this->boardService = new BoardService();
        $this->userService = new UserService();
        $this->projectService = new ProjectService();
    }

    public function createBoard(CreateBoardDto $dto): array {
        $board = $this->boardService->createBoardOnProject($dto);
        return (new BoardResponseDto(
            $board->getId(),
            $board->getProjectId(),
            $board->getName(),
        ))->toArray();
    }

    public function checkProjectIdAndUserId(int $userId, int $projectId): bool {
        try {
            $user = $this->userService->getUser($userId);
            $project = $this->projectService->getProjectById($projectId);
            return $user !== null && $project !== null;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getBoards(int $projectId): array {
        $boards = $this->boardService->getAllBoards($projectId);

        return array_map(function($board) {
            return (new BoardResponseDto(
                $board->getId(),
                $board->getProjectId(),
                $board->getName(),
            ))->toArray();
        }, $boards);
    }

    public function getBoard(int $id): array {
        $board = $this->boardService->getBoard($id);
        return (new BoardResponseDto(
            $board->getId(),
            $board->getProjectId(),
            $board->getName()))
            ->toArray();
    }

    public function updateBoard(UpdateBoardDto $dto, $boardId): array {
        $board = $this->boardService->updateBoard($boardId, $dto);
        return (new BoardResponseDto(
            $board->getId(),
            $board->getProjectId(),
            $board->getName(),
            $board->getCreatedAt(),
        ))->toArray();
    }

    public function deleteBoard(int $id): array {
        $result = $this->boardService->deleteBoard($id);
        return [
            'success' => $result,
            'message' => $result ? 'Board successfully deleted' : 'Board not found',
            'deletedId' => $id
        ];
    }
}