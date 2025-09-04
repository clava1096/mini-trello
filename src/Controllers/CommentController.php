<?php

namespace Src\Controllers;

use Src\DTO\Comment\CommentResponseDto;
use Src\DTO\Comment\CreateCommentDto;
use Src\Services\CommentService;

class CommentController {
    private CommentService $commentService;

    public function __construct() {
        $this->commentService = new CommentService();
    }

    public function createComment(int $userId, CreateCommentDto $dto): array {
        $comment = $this->commentService->createComment($dto, $userId);
        return (new CommentResponseDto(
            $comment->getId(),
            $comment->getCardId(),
            $comment->getUserId(),
            $comment->getContent(),
            $comment->getCreatedAt()
        ))->toArray();
    }

    public function getComments(int $cardId): array {
        $comments = $this->commentService->getCommentsByCardId($cardId);
        return array_map(function($comment) {
            return (new CommentResponseDto(
                $comment->getId(),
                $comment->getCardId(),
                $comment->getUserId(),
                $comment->getContent(),
                time() // TODO косяк со временем.
            ))->toArray();
        }, $comments);
    }

    public function deleteComment(int $id, int $userId): array {
        $result = $this->commentService->deleteComment($id, $userId);

        return [
            'success' => $result,
            'message' => $result ? 'Comment successfully deleted' : 'Comment not found',
            'deletedId' => $id
        ];
    }
}