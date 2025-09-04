<?php

use Src\Router;
use Src\Controllers\UserController;
use Src\DTO\User\UserCreateDto;
use Src\DTO\User\UserLoginDto;

return function (Router $router, UserController $userController) {
    // POST api/user/register
    $router->addRoute('POST', '/api/user/register', function() use ($userController) {
        $json = file_get_contents('php://input');
        $dto = UserCreateDto::fromJson($json);

        if (!empty($dto->validate())) {
            http_response_code(400);
            return $dto;
        }

        return $userController->createUser($dto);
    });

    // POST api/user/login
    $router->addRoute('POST', '/api/user/login', function() use ($userController) {
        $json = file_get_contents('php://input');
        $dto = UserLoginDto::fromJson($json);

        if (!empty($dto->validate())) {
            http_response_code(400);
            return $dto;
        }

        return $userController->authUser($dto);
    });

    // GET api/user/me
    $router->addRoute('GET', '/api/user/me', function() use ($userController) {
        $userId = requireAuth();
        return $userController->getUser($userId);
    });

    // POST api/user/logout
    $router->addRoute('POST', '/api/user/logout', function() use ($userController) {
        return $userController->logout();
    });

    // GET api/user/{id}
    $router->addRoute('GET', '/api/user/{id}', function($id) use ($userController) {
        requireAuth();
        return $userController->getUser((int)$id);
    });
};