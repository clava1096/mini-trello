<?php

namespace Src\Controllers;

use Src\Services\ProjectService;

class ProjectController {
    /*
    📁 Projects
        POST /api/projects – создать проект
        GET /api/projects – список всех проектов, где участвует пользователь
        GET /api/projects/:id – получить проект по id
        PUT /api/projects/:id – обновить проект (название/описание)
        DELETE /api/projects/:id – удалить проект
 */
    private ProjectService $projectService;

    public function __construct() {
        $this->projectService = new ProjectService();
    }

    public function createProject($dto): array {
        $project = $this->projectService->createProject($dto);
        return (new )
    }
}