<?php
return [
    'driver' => 'pgsql',
    'host' => getenv('DB_HOST') ?: 'db',
    'port' => getenv('DB_PORT') ?: 5432,
    'database' => getenv('DB_NAME') ?: 'app_db',
    'username' => getenv('DB_USER') ?: 'user',
    'password' => getenv('DB_PASSWORD') ?: 'password'
];
