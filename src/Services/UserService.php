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

        error_log("Input password: " . $dto->password);
        error_log("Stored hash: " . $user->getPassword());
        error_log("Password verify result: " . (password_verify($dto->password, $user->getPassword()) ? 'TRUE' : 'FALSE'));

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
        $user = new User(0, $dto->username, $dto->email, $hashedPassword);
        error_log(print_r($user, true));
        return $this->userRepo->create($user);
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