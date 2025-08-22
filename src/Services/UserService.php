<?php
namespace Src\Services;

use UnexpectedValueException;
use Src\DTO\User\UserCreateDto;
use Src\DTO\User\UserLoginDto;
use Src\Models\User;
use Src\Repository\UserRepository;

class UserService {

    private UserRepository $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }


    public function authenticate(UserLoginDto $dto): User {
        $user = $this->userRepo->getUserByUsername($dto->username);
        if (!$user) {
            throw new UnexpectedValueException('Email not found');
        }

        if (strcasecmp($user->getUsername(), $dto->username) !== 0) {
            throw new UnexpectedValueException("Username not found");
        }

        if (!password_verify($dto->password, $user->getPassword())) {
            throw new UnexpectedValueException("Wrong password");
        }

        return $user;
    }

    public function create(UserCreateDto $dto): User {
        if ($this->checkEmail($dto->email)) {
            throw new UnexpectedValueException("Email already exists");
        }
        if ($this->checkUsername($dto->username)) {
            throw new UnexpectedValueException("Username already exists");
        }

        $hashedPassword = password_hash(
            $dto->password,
            PASSWORD_DEFAULT,
            ['cost' => 12] // повышаем сложность хеширования
        );

        if (!$hashedPassword) {
            throw new UnexpectedValueException("Error while hash password");
        }

        return $this->userRepo->create($dto->username, $dto->email, $hashedPassword);
    }

    public function getUser($id): User {
        $user = $this->userRepo->findById($id);
        return $user ?? throw new UnexpectedValueException("This user does not exist");
    }

    private function checkEmail(string $email): bool {
        return (bool) $this->userRepo->getUserByEmail($email);
    }

    private function checkUsername(string $username): bool {
        return (bool) $this->userRepo->getUserByUsername($username);
    }

}