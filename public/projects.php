<?php

namespace public;

use Src\Controllers\ProjectController;
use Src\DTO\Project\ProjectCreateDto;
use Src\DTO\Project\ProjectUpdateDto;
use Src\Router;

return function (Router $router, ProjectController $projectsController) {
    // POST /api/projects – создать проект
    $router->addRoute('POST', '/api/projects', function() use ($projectsController) {
        requireAuth();
        $json = file_get_contents('php://input');
        $dto = ProjectCreateDto::fromJson($json);

        if (!empty($dto->validate())) {
            http_response_code(400);
            return $dto;
        }

        return $projectsController->createProject($dto);
    });

    // GET /api/projects – список проектов
    $router->addRoute('GET', '/api/projects', function() use ($projectsController) {
        $userId = requireAuth();
        return $projectsController->getProjects($userId);
    });

    // GET /api/projects/{id} – получить проект по id
    $router->addRoute('GET', '/api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        return $projectsController->getProject((int)$id);
    });

    // PUT /api/projects/{id} – обновить проект
    $router->addRoute('PUT', '/api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        $json = file_get_contents('php://input');
        $dto = ProjectUpdateDto::fromJson($json);

        if (!empty($dto->validate())) {
            http_response_code(400);
            return $dto;
        }
        return $projectsController->updateProject($dto);
    }); /// -------------------------------- TODO РАБОТАЕТ НО НУЖНО ПЕРЕДАВАТЬ ЗАЧЕМ-ТО ЕЩЕ ID В JSON. переделать!!!

    // DELETE /api/projects/{id} – удалить проект
    $router->addRoute('DELETE', '/api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        return $projectsController->deleteProject((int)$id);
    });
};