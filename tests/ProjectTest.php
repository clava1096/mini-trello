<?php

use Src\Controllers\ProjectController;

require_once __DIR__ . '/ApiTestBase.php';
class ProjectTest extends ApiTestBase {

    protected function setUp(): void
    {
        parent::setUp();

        // Подключаем контроллер и маршруты проектов

        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['id'] = 1;

        $projectsController = new ProjectController();
        $projectRoutes = require __DIR__ . '/../public/projects.php';
        $projectRoutes($this->router, $projectsController);
    }
    public function testCreateProjectSuccess()
    {
        $data = [
            'name' => 'Test Project ' . uniqid(),
            'description' => 'Test Description',
            'ownerId' => 1 // тестовый юзер, можно захардкодить
        ];

        $response = $this->makeRequest('POST', '/api/projects', $data);

        var_dump($response);
        // Сохраняем ID для следующих тестов
        self::$projectId = $response['id'];
    }

    public function testCreateProjectValidationError()
    {
        $data = ['name' => '', 'ownerId' => 0];
        $response = $this->makeRequest('POST', '/api/projects', $data);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testGetProjectsList()
    {
        $response = $this->makeRequest('GET', '/api/projects');
        $this->assertIsArray($response);
    }

    public function testGetProjectById()
    {
        $response = $this->makeRequest('GET', '/api/projects/1');
        $this->assertArrayHasKey('id', $response);
    }

    public function testUpdateProject()
    {
        $data = [
            'id' => 1,
            'name' => 'Updated Project',
            'description' => 'Updated Description'
        ];

        $response = $this->makeRequest('PUT', '/api/projects/1', $data);
        $this->assertArrayHasKey('id', $response);
    }

    public function testDeleteProject()
    {
        $response = $this->makeRequest('DELETE', '/api/projects/1');
        $this->assertArrayHasKey('message', $response);
    }
}