<?php

use Src\Controllers\ProjectMembersController;
use Src\DTO\ProjectMembers\ProjectMembersAddDto;
use Src\DTO\ProjectMembers\ProjectMembersDeleteDto;
use Src\Router;

return function (Router $router, ProjectMembersController $projectsMembersController) {
    // POST /api/projects/{id}/members – добавить пользователя в проект
    $router->addRoute('POST', '/api/projects/{id}/members', function($id) use ($projectsMembersController) {
        requireAuth();

        $json = file_get_contents('php://input');
        $dto = ProjectMembersAddDto::fromJson($json);

        $res = $projectsMembersController->addMemberToProject($dto, $id);
        if ($res) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    });

    // GET /api/projects/{id}/members – список участников проекта
    $router->addRoute('GET', '/api/projects/{id}/members', function($id) use ($projectsMembersController) {
        requireAuth();
        return $projectsMembersController->getAllMembersFromProject((int)$id);
    });

    // DELETE /api/projects/{id}/members/{user_id} – удалить участника из проекта
    $router->addRoute('DELETE', '/api/projects/{id}/members/{user_id}', function($id, $user_id) use ($projectsMembersController) {
        $json = file_get_contents('php://input');
        $dto = ProjectMembersDeleteDto::fromJson($json);
        $res = $projectsMembersController->removeMemberFromProject($id, $user_id);
        if ($res) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }); // +++++++++++++++++++++++++++++++++++++++
};