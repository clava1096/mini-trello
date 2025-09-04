<?php

namespace Src\Services;

use Src\DTO\Project\ProjectCreateDto;
use Src\DTO\Project\ProjectUpdateDto;
use Src\Models\Project;
use Src\Repository\ProjectRepository;

class ProjectService {
    private ProjectRepository $projectRepo;

    public function __construct() {
        $this->projectRepo = new ProjectRepository();
    }

    public function createProject(ProjectCreateDto $dto): Project {
        $project = new Project(0, $dto->name, $dto->description, $dto->ownerId, time());
        return $this->projectRepo->create($project);
    }

    public function getAllProjectsByUserId(int $userId): array {
        return $this->projectRepo->getAllProjectsByUserId($userId);
    }

    public function getProjectById(int $id): Project {
        return $this->projectRepo->getProjectById($id);
    }

    public function updateProject(ProjectUpdateDto $dto): Project {
        $project = $this->projectRepo->getProjectById($dto->id);
        if (!$project) {
            throw new Exception("Project not found");
        }

        if (!empty($dto->name)) {
            $project->setName($dto->name);
        }

        if (!empty($dto->description)) {
            $project->setDescription($dto->description);
        }

        $this->projectRepo->update($project);

        return $project; // Возвращаем обновленный проект
    }

    public function deleteProjectById(int $id): bool {
        return $this->projectRepo->delete($id);
    }
}