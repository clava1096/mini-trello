<?php

namespace Src;

class Router {
    private static array $routes = [];

    public function addRoute(string $method, string $pattern, callable $handler) {
        self::$routes[] = [
            'method'  => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(string $uri) {
        $path   = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if ($method !== $route['method']) {
                continue;
            }

            // преобразуем шаблон: /user/{id} → /user/(\d+)
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['pattern']);

            if (preg_match("#^{$regex}$#", $path, $matches)) {
                array_shift($matches); // убираем полный матч

                header('Content-Type: application/json; charset=utf-8');
                try {
                    $response = call_user_func_array($route['handler'], $matches);
                } catch (\Exception $e)  {
                    $object = new \stdClass();
                    $object->error = $e->getMessage();
                    echo json_encode($object);
                    return;
                }
                echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                return;
            }
        }

        self::notFound();
    }

    private function notFound() {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["error" => "Страница не найдена"]);
    }
}