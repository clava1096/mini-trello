<?php

use Src\Controllers\BoardController;
use Src\DTO\Board\CreateBoardDto;
use Src\Router;

return function (Router $router, BoardController $boardController) {
    $router->addRoute('POST', '/api/projects/{id}/boards', function($id) use ($boardController) {
        $userId = requireAuth();
        $json = file_get_contents('php://input');
        $dto = CreateBoardDto::fromJson($json);

        $errors = $dto->validate();
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        if (!$boardController->checkProjectIdAndUserId($userId, $dto->projectId)) {
            http_response_code(404);
            return ["error" => "not found project or user id"];
        }

        return $boardController->createBoard($dto);
    });

    $router->addRoute('GET', '/api/projects/{id}/boards', function($id) use ($boardController) {
        requireAuth();
        return $boardController->getBoards($id);
    });

    $router->addRoute('GET', '/api/boards/{id}', function($id) use ($boardController) {
        requireAuth();
        return $boardController->getBoard($id);
    });

    $router->addRoute('DELETE', '/api/boards/{id}', function($id) use ($boardController) {
        requireAuth();
        return $boardController->deleteBoard($id);
    });
};