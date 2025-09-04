<?php

namespace Src\Repository;

use PDO;
use Config\Db\Database;
class ProjectMembersRepository implements ProjectMembersRepositoryInterface {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function addMemberToProject(int $projectId, array $userIds): bool
    {
        if (empty($userIds)) {
            return 0;
        }

        // Удаляем дубликаты
        $userIds = array_unique($userIds);

        // Создаем плейсхолдеры для запроса
        $placeholders = [];
        $values = [];

        foreach ($userIds as $index => $userId) {
            $placeholders[] = "(:project_id, :user_id_$index)";
            $values["user_id_$index"] = $userId;
        }

        $values['project_id'] = $projectId;

        // Используем INSERT IGNORE чтобы пропустить дубликаты
        $sql = "
        INSERT IGNORE INTO projects_members (project_id, user_id) 
        VALUES " . implode(', ', $placeholders);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        return $stmt->rowCount();
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