<?php

namespace Src\Repository;

use Config\Db\Database;
use PDO;
use Src\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create(Project $project): Project {
        $stmt = $this->db->prepare(
            "INSERT INTO projects (name, description, owner_id, created_at)
         VALUES (:name, :description, :ownerId, :createdAt)"
        );
        $stmt->execute([
            "name" => $project->getName(),
            "description" => $project->getDescription(),
            "ownerId" => $project->getOwnerId(),
            "createdAt" => $project->getCreatedAt()
        ]);

        $id = (int)$this->db->lastInsertId();
        $project->setId($id);

        return $project;
    }

    public function update(Project $newProject): bool {
        $stmt = $this->db->prepare(
            "UPDATE projects
           SET name = :name,
             description = :description,
             owner_id = :ownerId,
             created_at = : createdAt
          WHERE id = :id"
        );

        $stmt->execute([
            'id'          => $newProject->getId(),
            'name'        => $newProject->getName(),
            'description' => $newProject->getDescription(),
            'ownerId'     => $newProject->getOwnerId(),
            'createdAt'   => $newProject->getCreatedAt(),
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $projectId): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM projects WHERE id = ?"
        );
        $stmt->execute([$projectId]);
        return $stmt->rowCount() > 0;
    }

    public function getProjectById(int $id): ?Project
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM projects WHERE id = :?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Project($row['id'], $row['name'], $row['description'], $row['ownerId'], $row['createdAt']);
        }
        return null;
    }

    public function getAllProjectsByUserId(int $userId): array {
        $stmt = $this->db->prepare(
            "SELECT p.*
            FROM projects p
            LEFT JOIN projects_members pm on p.id = pm.project_id
            WHERE pm.user_id = :userId OR p.owner_id = :userId");
        $stmt->execute(['userId' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $projects = [];

        foreach ($rows as $row) {
            $projects[] = new Project($row['id'],
                $row['name'],
                $row['description'],
                $row['ownerId'],
                $row['createdAt']);
        }

        return $projects;
    }
}