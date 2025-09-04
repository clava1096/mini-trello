<?php

use Src\Controllers\ColumnController;
use Src\DTO\Column\CreateColumnDto;
use Src\DTO\Column\UpdateColumnDto;
use Src\Router;

return function (Router $router, ColumnController $columnController) {
    $router->addRoute('POST', '/api/boards/{id}/columns', function($id) use ($columnController) {
        requireAuth();
        $json = file_get_contents('php://input');
        $dto = CreateColumnDto::fromJson($json);
        $errors = $dto->validate();
        $dto->boardId = $id;
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        return $columnController->createColumn($dto);
    });

    $router->addRoute('GET', '/api/boards/{id}/columns', function($id) use ($columnController) {
        requireAuth();
        return $columnController->getColumns((int)$id);
    });

    $router->addRoute('PUT', '/api/columns/{id}', function($id) use ($columnController) {
        requireAuth();
        $json = file_get_contents('php://input');
        $dto = UpdateColumnDto::fromJson($json);

        $errors = $dto->validate();
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        return $columnController->updateColumn((int)$id, $dto);
    });

    $router->addRoute('DELETE', '/api/columns/{id}', function($id) use ($columnController) {
        requireAuth();
        return $columnController->deleteColumn((int)$id);
    });
};