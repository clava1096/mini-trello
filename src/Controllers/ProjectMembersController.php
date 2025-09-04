<?php

namespace Src\Controllers;

use Src\DTO\ProjectMembers\ProjectMembersAddDto;
use Src\DTO\ProjectMembers\ProjectMembersDeleteDto;
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

    public function removeMemberFromProject($id, $user_id): bool
    {
        return $this->projectMembersService->removeMemberFromProject($id, $user_id);
    }

    public function getAllMembersFromProject(int $projectId): array {
        return $this->projectMembersService->getAllMembersFromProject($projectId);
    }
}