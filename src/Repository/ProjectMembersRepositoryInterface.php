<?php

namespace Src\Repository;

interface ProjectMembersRepositoryInterface {
    public function addMemberToProject(int $projectId, array $userIds): bool;
    public function removeMemberFromProject($projectId, $memberId): bool;
    public function getAllMembersFromProject($projectId): array;
}