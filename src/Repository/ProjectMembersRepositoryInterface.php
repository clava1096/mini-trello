<?php

namespace Src\Repository;

interface ProjectMembersRepositoryInterface {
    public function addMemberToProject($projectId, $memberId): bool;
    public function removeMemberFromProject($projectId, $memberId): bool;
    public function getAllMembersFromProject($projectId): array;
}