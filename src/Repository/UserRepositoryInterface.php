<?php

namespace Src\Repository;

use Src\Models\User;

interface UserRepositoryInterface {
    function findById(int $id): ?User;
    function getUserByUsername(string $username): ?User;
    function getUserByEmail(string $email): ?User;
}