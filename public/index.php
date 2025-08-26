<?php
spl_autoload_register(function ($class) {
    $prefix = "Src\\";

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $file = __DIR__ . "/../src/" . str_replace("\\", "/", substr($class, 4)) . ".php";

    if (file_exists($file)) {
        require $file;
    }
});
require_once __DIR__ . '/../config/db/Db.php';

use Src\Controllers\UserController;
use Src\Controllers\ProjectController;
use Src\DTO\User\UserCreateDto;
use Src\DTO\User\UserLoginDto;
use Src\Router;


$userController = new UserController();
$projectsController = new ProjectController();

$router = new Router();

// USER:
{
    // POST api/user/register + json
    $router->addRoute('POST', 'api/user/register', function() use ($userController) {
        $json = file_get_contents('php://input');
        $dto = UserCreateDto::fromJson($json);

        if (!empty($dto->validate())) {
            return $dto;
        }

        return $userController->createUser($dto);
    });

    // POST api/user/login + json
    $router->addRoute('POST', 'api/user/login', function() use ($userController) {
        $json = file_get_contents('php://input');
        $dto = UserLoginDto::fromJson($json);

        if (!empty($dto->validate())) {
            return $dto;
        }

        return $userController->authUser($dto);
    });

    // GET api/user/me
    $router->addRoute('GET', 'api/user/me', function() use ($userController) {
        $userId = requireAuth();
        return $userController->getUser($userId);
    });

    // GET api/user/{id}
    $router->addRoute('GET', 'api/user/{id}', function($id) use ($userController) {
        requireAuth();
        return $userController->getUser($id);
    });

    // POST api/user/logout
    $router->addRoute('POST', 'api/user/logout', fn() => $userController->logout());

}

// PROJECTS:
{
    // POST /api/projects – создать проект
    $router->addRoute('POST', '/api/projects', function() use ($projectsController) {

    });

    //GET /api/projects – список всех проектов, где участвует пользователь
    $router->addRoute('POST', '/api/projects', function() use ($projectsController) {
        $userId = requireAuth();
        return $projectsController->getProjects($userId);
    });

    //GET /api/projects/:id – получить проект по id
    $router->addRoute('POST', '/api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        return $projectsController->getProject($id);
    });

    //PUT /api/projects/:id – обновить проект (название/описание)
    $router->addRoute('GET', 'api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        return $projectsController->getProject($id);
    });
    //DELETE /api/projects/:id – удалить проект
    $router->addRoute('DELETE', 'api/projects/{id}', function($id) use ($projectsController) {
        requireAuth();
        return $projectsController->deleteProject($id);
    });
}

// PROJECT MEMBERS:
{

}
$router->dispatch($_SERVER['REQUEST_URI']);



function requireAuth(): int {
    session_name("PHPSESSID"); // или "HTTPSESSION", если ты сменил имя
    session_start();

    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit; // завершаем выполнение
    }

    return $_SESSION['id']; // можно вернуть id пользователя
}
/*
 * написать свою систему id
 *
🔑 Auth / Users
POST /api/register – регистрация пользователя
POST /api/login – авторизация (возвращает токен / сессию)
POST /api/logout
GET /api/users/me – получить свой профиль
GET /api/users/:id – получить данные другого пользователя (по id)

📁 Projects
POST /api/projects – создать проект
GET /api/projects – список всех проектов, где участвует пользователь
GET /api/projects/:id – получить проект по id
PUT /api/projects/:id – обновить проект (название/описание)
DELETE /api/projects/:id – удалить проект

👥 Project Members
POST /api/projects/:id/members – добавить пользователя в проект
{ "user_id": 5 }
GET /api/projects/:id/members – список участников проекта
DELETE /api/projects/:id/members/:user_id – удалить участника из проекта

📋 Boards
POST /api/projects/:id/boards – создать доску в проекте
GET /api/projects/:id/boards – список досок проекта
GET /api/boards/:id – получить доску по id
PUT /api/boards/:id – обновить доску (название)
DELETE /api/boards/:id – удалить доску

🗂 Columns
POST /api/boards/:id/columns – создать колонку в доске
GET /api/boards/:id/columns – список колонок в доске
PUT /api/columns/:id – обновить колонку (название, position)
DELETE /api/columns/:id – удалить колонку

📝 Cards
POST /api/columns/:id/cards – создать карточку в колонке
{ "title": "Fix bug", "description": "…" }
GET /api/columns/:id/cards – список карточек в колонке
GET /api/cards/:id – получить карточку
PUT /api/cards/:id – обновить карточку (title, description, column_id, position)
DELETE /api/cards/:id – удалить карточку

💬 Comments
POST /api/cards/:id/comments – добавить комментарий
{ "content": "Пофиксил баг 👍" }
GET /api/cards/:id/comments – список комментариев к карточке
DELETE /api/comments/:id – удалить комментарий
 */
