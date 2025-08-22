<?php

namespace Src\Repository;

use Src\Models\Project;

interface ProjectRepositoryInterface {
    public function create(Project $project): Project;
    public function update(Project $newProject): bool;

    public function delete(int $projectId): bool;

    public function getProjectById(int $id): ?Project;

    public function getAllProjectsByUserId(int $userId): array;
}