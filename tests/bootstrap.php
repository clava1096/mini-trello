<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (!function_exists('requireAuth')) {
    function requireAuth(): int {
        // Симулируем авторизованного пользователя
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION['id'] ?? 1; // По умолчанию всегда id=1
    }
}