<?php
// ==================== CORS HANDLING ====================
header('Access-Control-Allow-Origin: http://localhost:9000');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 3600');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Set content type for all responses
header('Content-Type: application/json');

error_log('Request method: ' . $_SERVER['REQUEST_METHOD']);
error_log('Request URI: ' . $_SERVER['REQUEST_URI']);
error_log('Content-Type: ' . ($_SERVER['CONTENT_TYPE'] ?? 'not set'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    error_log('Request body: ' . $input);
}

// ==================== ORIGINAL CODE ====================
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
use Src\Controllers\ProjectMembersController;
use Src\Controllers\BoardController;
use Src\Controllers\ColumnController;
use Src\Controllers\CardController;
use Src\Controllers\CommentController;
use Src\Router;

$userController = new UserController();
$projectsController = new ProjectController();
$projectMembersController = new ProjectMembersController();
$boardController = new BoardController();
$columnController = new ColumnController();
$cardController = new CardController();
$commentController = new CommentController();

$router = new Router();

//  USER
$userRoutes = require __DIR__ . '/user.php';
$userRoutes($router, $userController);

//  PROJECTS
$projectRoutes = require __DIR__ . '/projects.php';
$projectRoutes($router, $projectsController);

//  PROJECT MEMBERS
$projectMembersRoutes = require __DIR__ . '/project_members.php';
$projectMembersRoutes($router, $projectMembersController);

//  BOARDS
$boardRoutes = require __DIR__ . '/boards.php';
$boardRoutes($router, $boardController);

//  COLUMNS
$columnRoutes = require __DIR__ . '/columns.php';
$columnRoutes($router, $columnController);

//  CARDS
$cardRoutes = require __DIR__ . '/cards.php';
$cardRoutes($router, $cardController);

//  COMMENTS
$commentRoutes = require __DIR__ . '/comments.php';
$commentRoutes($router, $commentController);


// Add error handling for the router
try {
    $router->dispatch($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
}



function requireAuth(): int {
    session_name("PHPSESSID");
    session_start();

    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        throw new Exception("Unauthorized");
    }

    return $_SESSION['id'];
}
/*

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