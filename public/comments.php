<?php


use Src\Controllers\CommentController;
use Src\DTO\Comment\CreateCommentDto;
use Src\Router;

return function (Router $router, CommentController $commentController) {
    $router->addRoute('POST', '/api/cards/{id}/comments', function ($id) use ($commentController) {
        $userId = requireAuth();
        $json = file_get_contents('php://input');
        $dto = CreateCommentDto::fromJson($json);
        $errors = $dto->validate();
        $dto->cardId = $id;
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        return $commentController->createComment($userId, $dto);
    });

    $router->addRoute('GET', '/api/cards/{id}/comments', function ($id) use ($commentController) {
        requireAuth();
        return $commentController->getComments((int)$id);
    });

    $router->addRoute('DELETE', '/api/comments/{id}', function ($id) use ($commentController) {
        $userId = requireAuth();
        return $commentController->deleteComment((int)$id, $userId);
    });
};