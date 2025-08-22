<?php

namespace Src\Repository;

use Config\Db\Database;
use Src\Models\User;
use PDO;

class UserRepository implements UserRepositoryInterface {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['id'], $row['username'], $row['email'], $row['password']);
        }
        return null;
    }

    public function create(User $user): User {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password) 
         VALUES (:username, :email, :password)"
        );

        $stmt->execute([
            'username' => $user->getUsername(),
            'email'    => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        $id = (int)$this->db->lastInsertId();
        $user->setId($id);

        return $user;
    }

    public function getUserByUsername(string $username): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['id'], $row['username'], $row['email'], $row['password']);
        }
        return null;
    }

    public function getUserByEmail(string $email): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['id'], $row['username'], $row['email'], $row['password']);
        }
        return null;
    }
}