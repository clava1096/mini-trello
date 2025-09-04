<?php

namespace Src\Controllers;

use Src\DTO\ProjectMembers\ProjectMembersAddDto;
use Src\Models\Project;
use Src\Models\ProjectMembers;
use Src\Services\ProjectMembersService;

class ProjectMembersController {
    private ProjectMembersService $projectMembersService;

    public function __construct() {
        $this->projectMembersService = new ProjectMembersService();
    }

    public function addMemberToProject(ProjectMembersAddDto $dto, $id): bool
    {
        return $this->projectMembersService->addMemberToProject($dto, $id);
    }

    public function removeMemberFromProject(ProjectMembersAddDto $dto): ProjectMembers {
        return $this->projectMembersService->removeMemberFromProject($dto);
    }

    public function getAllMembersFromProject(int $projectId): array {
        return $this->projectMembersService->getAllMembersFromProject($projectId);
    }
}