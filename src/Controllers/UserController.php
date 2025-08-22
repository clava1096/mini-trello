<?php

namespace Src\Controllers;

use Src\Services\UserService;
use Src\DTO\User\UserResponseDto;

class UserController {

    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function createUser($dto): array {
        $user = $this->userService->create($dto);
        return (new UserResponseDto($user->getId(), $user->getUsername(), $user->getEmail()))->toArray();
    }

    public function getUser(int $id): array {
        $user = $this->userService->getUser($id);
        return (new UserResponseDto($user->getId(), $user->getUsername(), $user->getEmail()))->toArray();
    }

    public function authUser($dto): array {
        $user = $this->userService->authenticate($dto);

        session_start();
        session_regenerate_id(true);
        $_SESSION['id'] = $user->getId();

        return ["message" => "Logged in successfully"];
    }

    public function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();
        return ["message" => "Logout successful"];
    }

}
