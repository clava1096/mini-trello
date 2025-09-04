<?php

use Src\Controllers\CardController;
use Src\DTO\Card\CreateCardDto;
use Src\DTO\Card\UpdateCardDto;
use Src\Router;

return function (Router $router, CardController $cardController) {
    $router->addRoute('POST', '/api/columns/{id}/cards', function ($id) use ($cardController) {
        $userId = requireAuth();
        $json = file_get_contents('php://input');
        $dto = CreateCardDto::fromJson($json);

        $errors = $dto->validate();
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        return $cardController->createCard($dto, $userId);
    });

    $router->addRoute('GET', '/api/columns/{id}/cards', function ($id) use ($cardController) {
        requireAuth();
        return $cardController->getCards((int)$id);
    });

    $router->addRoute('GET', '/api/cards/{id}', function ($id) use ($cardController) {
        requireAuth();
        return $cardController->getCard((int)$id);
    });

    $router->addRoute('PUT', '/api/cards/{id}', function ($id) use ($cardController) {
        requireAuth();
        $json = file_get_contents('php://input');
        $dto = UpdateCardDto::fromJson($json);

        $errors = $dto->validate();
        if (!empty($errors)) {
            http_response_code(400);
            return ["errors" => $errors];
        }

        return $cardController->updateCard((int)$id, $dto);
    });

    $router->addRoute('DELETE', '/api/cards/{id}', function ($id) use ($cardController) {
        requireAuth();
        return $cardController->deleteCard((int)$id);
    });
};