<?php

namespace Src\Services;

use Src\DTO\ProjectMembers\ProjectMembersAddDto;
use Src\DTO\ProjectMembers\ProjectMembersDeleteDto;
use Src\Models\ProjectMembers;
use Src\Repository\ProjectMembersRepository;

class ProjectMembersService {


    /*
     *
     * 👥 Project MembersPOST /api/projects/:id/members – добавить пользователя в проект { "user_id": 5 }
     * GET /api/projects/:id/members – список участников проекта
     * DELETE /api/projects/:id/members/:user_id – удалить участника из проекта
     *
     * */

    private ProjectMembersRepository $projectMembersRepository;

    public function __construct() {
        $this->projectMembersRepository = new ProjectMembersRepository();
    }

    public function addMemberToProject(ProjectMembersAddDto $dto, int $id): bool
    {
        return $this->projectMembersRepository->addMemberToProject($id, $dto->userIds);
    }

    public function removeMemberFromProject($id, $user_id): bool
    {
        return $this->projectMembersRepository->removeMemberFromProject($id, $user_id);
    }

    public function getAllMembersFromProject(int $projectId): array {
        if ($projectId  < 0 ) {
            throw new InvalidArgumentException("your projectId must be not null");
        }
        return $this->projectMembersRepository->getAllMembersFromProject($projectId);
    }


}