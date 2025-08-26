<?php

namespace Src\Services;

use Src\DTO\ProjectMembers\ProjectMembersAddDto;
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
        $projectMembersRepository = new ProjectMembersRepository();
    }

    public function addMemberToProject(ProjectMembersAddDto $dto): ProjectMembers {

    }

    public function removeMemberFromProject(ProjectMembersAddDto $dto): ProjectMembers {

    }

    public function get()
    {

    }


}