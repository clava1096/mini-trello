<?php

namespace Src\Controllers;

use Src\DTO\Project\ProjectResponseDto;
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
        return (new ProjectResponseDto($project->getId(), $project->getName(), $project->getDescription(),$project->getOwnerId(), $project->getCreatedAt()))->toArray();
    }

    public function getProject(int $id): array {
        $project = $this->projectService->getProjectById($id);
        return (new ProjectResponseDto(
            $project->getId(),
            $project->getName(),
            $project->getDescription(),
            $project->getOwnerId()
        ))->toArray();
    }

    public function getProjects(int $userId): array {
        $projects = $this->projectService->getAllProjectsByUserId($userId);

        return array_map(function($project) {
            return (new ProjectResponseDto(
                $project->getId(),
                $project->getName(),
                $project->getDescription(),
                $project->getOwnerId()
            ))->toArray();
        }, $projects);
    }

    public function updateProject($dto): array {
        $project = $this->projectService->updateProject($dto);
        return (new ProjectResponseDto($project->getId(), $project->getName(), $project->getDescription(),$project->getOwnerId(), $project->getCreatedAt()))->toArray();
    }

    public function deleteProject(int $id): array {
        $result = $this->projectService->deleteProjectById($id);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Project successfully deleted',
                'deletedId' => $id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Project not found or could not be deleted'
            ];
        }
    }

}