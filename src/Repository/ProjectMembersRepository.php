<?php

namespace Src\Repository;

use PDO;
use Config\Db\Database;
class ProjectMembersRepository implements ProjectMembersRepositoryInterface {
    private PDO $pdo;

    public function __construct() {
        $pdo = Database::getConnection();
    }

    public function addMemberToProject($projectId, $memberId): bool {
        $stmt = $this->pdo->prepare("
        INSERT INTO projects_members (project_id, user_id) VALUES (:project_id, :member_id)");
        $stmt->execute([
            "project_id" => $projectId,
            "member_id" => $memberId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function removeMemberFromProject($projectId, $memberId): bool {
        $stmt = $this->pdo->prepare("
        DELETE FROM projects_members WHERE project_id = :project_id and user_id = :member_id");
        $stmt->execute([
            "project_id" => $projectId,
            "member_id" => $memberId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function getAllMembersFromProject($projectId): array {
        $stmt = $this->pdo->prepare("
        SELECT pm.user_id
        FROM projects_members pm
        WHERE project_id = :project_id");
        $stmt->execute(["project_id" => $projectId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $members = [];
        foreach ($rows as $row) {
            $members[] = $row['user_id'];
        }
        return $members;
    }
}