<?php

echo "Run migration \n";

$migrationsDir = __DIR__ . '/migrations/';

$files = scandir($migrationsDir);

foreach ($files as $file) {
    if (preg_match('/\.php$/', $file)) {
        echo "Exec: $file \n";
        require_once $migrationsDir . '/' . $file;
    }
}

echo "All migration are done!\n";