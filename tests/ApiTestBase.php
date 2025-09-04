<?php

use Src\Router;

abstract class ApiTestBase extends PHPUnit\Framework\TestCase {
    protected Router $router;

    protected function setUp(): void
    {
        // Каждый наследник сам решает, какие контроллеры и роуты подключать
        $this->router = new Router();
    }

    protected function makeRequest(string $method, string $uri, array $data = null): array
    {
        // Симулируем HTTP запрос
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        if ($data) {
            // Подменяем тело запроса
            $GLOBALS['__TEST_INPUT'] = json_encode($data);

            // Хак для php://input
            stream_wrapper_unregister("php");
            stream_wrapper_register("php", "TestPhpStream");
        }

        // Захватываем вывод
        ob_start();
        $this->router->dispatch($uri);
        $output = ob_get_clean();

        if ($data) {
            stream_wrapper_restore("php"); // возвращаем обратно стандартный php://input
        }

        return json_decode($output, true) ?? [];
    }
}

// Вспомогательный класс для подмены php://input
class TestPhpStream {
    protected $index = 0;
    protected $content;

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $this->content = $GLOBALS['__TEST_INPUT'] ?? '';
        return true;
    }

    public function stream_read($count)
    {
        $ret = substr($this->content, $this->index, $count);
        $this->index += strlen($ret);
        return $ret;
    }

    public function stream_eof()
    {
        return $this->index >= strlen($this->content);
    }

    public function stream_stat()
    {
        return [];
    }
}