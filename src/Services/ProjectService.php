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
        $project = new Project(null, $dto->name, $dto->description, $dto->ownerId, time());
        return $this->projectRepo->create($project);
    }

    public function getAllProjectsByUserId(int $userId): array {
        return $this->projectRepo->getAllProjectsByUserId($userId);
    }

    public function getProjectById(int $id): Project {
        return $this->projectRepo->getProjectById($id);
    }

    public function updateProject(ProjectUpdateDto $dto): bool {
        $project = $this->projectRepo->getProjectById($dto->id);
        $project->setName($dto->name);
        $project->setDescription($dto->description);
        return $this->projectRepo->update($project);
    }

    public function deleteProjectById(int $id): bool {
        return $this->projectRepo->delete($id);
    }
}