<?php

namespace Src\Repository;

use Src\Models\Comment;

interface CommentsRepositoryInterface {
    public function create(Comment $comment): Comment;
    public function getAllComments(int $cardId): array;

    public function delete(int $id): bool;
}