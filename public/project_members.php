<?php

use Src\Controllers\ProjectMembersController;
use Src\DTO\ProjectMembers\ProjectMembersAddDto;
use Src\Router;

return function (Router $router, ProjectMembersController $projectsMembersController) {
    // POST /api/projects/{id}/members – добавить пользователя в проект
    $router->addRoute('POST', '/api/projects/{id}/members', function($id) use ($projectsMembersController) {
        requireAuth();

        $json = file_get_contents('php://input');
        $dto = ProjectMembersAddDto::fromJson($json);

        return $projectsMembersController->addMemberToProject($dto, $id);
    }); // +++++++++++++++++++++++++++++++++++++++ TODO переделать ответ сервераTODO

    // GET /api/projects/{id}/members – список участников проекта
    $router->addRoute('GET', '/api/projects/{id}/members', function($id) use ($projectsMembersController) {
        requireAuth();
        return $projectsMembersController->getAllMembersFromProject((int)$id);
    }); //+++++++++++++++++++++++++++++++++++++++++

    // DELETE /api/projects/{id}/members/{user_id} – удалить участника из проекта
    $router->addRoute('DELETE', '/api/projects/{id}/members/{user_id}', function($id, $user_id) use ($projectsMembersController) {
        $currentUserId = requireAuth();
        $json = file_get_contents('php://input');
        $dto = ProjectMembersAddDto::fromJson($json);
        // TODO дописать проверку на то что удаляет админимстратор или создатель проекта
        return $projectsMembersController->removeMemberFromProject((int)$id, (int)$user_id, $currentUserId);
    }); // +++++++++++++++++++++++++++++++++++++++
};