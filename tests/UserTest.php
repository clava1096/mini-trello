<?php

use Src\Controllers\UserController;

require_once __DIR__ . '/ApiTestBase.php';
class UserTest extends ApiTestBase
{
    protected function setUp(): void
    {
        parent::setUp();

        $userController = new UserController();
        $userRoutes = require __DIR__ . '/../public/user.php';
        $userRoutes($this->router, $userController);
    }

    public function testUserRegistrationSuccess()
    {
        $data = [
            'username' => 'user_' . uniqid(),
            'email' => 'user_' . uniqid() . '@example.com',
            'password' => 'password123'
        ];

        $response = $this->makeRequest('POST', '/api/user/register', $data);

        $this->assertIsArray($response);
    }

    public function testUserRegistrationValidationError()
    {
        $data = [
            'username' => '', // обязательное поле
            'email' => 'not-an-email',
            'password' => '123' // слишком короткий
        ];

        $response = $this->makeRequest('POST', '/api/user/register', $data);

        $this->assertIsArray($response);
    }

    public function testUserLoginSuccess()
    {
        // Сначала создаём пользователя
        $username = 'loginuser_' . uniqid();
        $password = 'password123';

        $this->makeRequest('POST', '/api/user/register', [
            'username' => $username,
            'email' => $username . '@example.com',
            'password' => $password
        ]);

        // Теперь логинимся по username
        $response = $this->makeRequest('POST', '/api/user/login', [
            'username' => $username,
            'password' => $password
        ]);

        $this->assertIsArray($response);
    }

    public function testUserLoginValidationError()
    {
        $response = $this->makeRequest('POST', '/api/user/login', [
            'username' => '',
            'password' => ''
        ]);

        $this->assertIsArray($response);
    }

    public function testGetCurrentUser()
    {
        $response = $this->makeRequest('GET', '/api/user/me');

        $this->assertIsArray($response);
    }

    public function testGetUserById()
    {
        $response = $this->makeRequest('GET', '/api/user/1');

        $this->assertIsArray($response);
    }

    public function testLogout()
    {
        $response = $this->makeRequest('POST', '/api/user/logout');

        $this->assertIsArray($response);
    }
}