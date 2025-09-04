<?php

namespace Src\Services;

use Exception;
use Src\DTO\Comment\CreateCommentDto;
use Src\Models\Comment;
use Src\Repository\CommentsRepository;

class CommentService {

    /*
     💬 Comments
    POST /api/cards/:id/comments – добавить комментарий
    { "content": "Пофиксил баг 👍" }
    GET /api/cards/:id/comments – список комментариев к карточке
    DELETE /api/comments/:id – удалить комментарий
     * */

    private CommentsRepository $commentsRepository;

    public function __construct() {
        $this->commentsRepository = new CommentsRepository();
    }

    public function createComment(CreateCommentDto $dto, int $userId): Comment {
        $comment = new Comment(
            0,
            $dto->cardId,
            $userId,
            $dto->content,
            time()
        );

        return $this->commentsRepository->create($comment);
    }

    public function getCommentsByCardId(int $cardId): array {
        return $this->commentsRepository->getAllComments($cardId);
    }

    public function getCommentById(int $commentId): Comment {
        $comment = $this->commentsRepository->getComment($commentId);
        if (!$comment) {
            throw new Exception("Comment not found");
        }
        return $comment;
    }

    public function deleteComment(int $commentId, int $userId): bool {
        $comment = $this->getCommentById($commentId);

        // Проверка, что пользователь может удалять только свои комментарии
        if ($comment->getUserId() !== $userId) {
            throw new Exception("You can only delete your own comments");
        }

        return $this->commentsRepository->delete($commentId);
    }

}