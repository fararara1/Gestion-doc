<?php
header('Content-Type: application/json');

$info = [
    'php_version' => phpversion(),
    'app_env' => getenv('APP_ENV') ?: 'not set',
    'app_key' => getenv('APP_KEY') ? 'set' : 'missing',
    'app_url' => getenv('APP_URL') ?: 'not set',
    'db_connection' => getenv('DB_CONNECTION') ?: 'not set',
    'db_host' => getenv('DB_HOST') ?: 'not set',
    'db_database' => getenv('DB_DATABASE') ?: 'not set',
    'db_username' => getenv('DB_USERNAME') ?: 'not set',
    'session_driver' => getenv('SESSION_DRIVER') ?: 'not set',
    'cache_driver' => getenv('CACHE_STORE') ?: 'not set',
];

try {
    $pdo = new PDO(
        'mysql:host=' . ($info['db_host'] ?: 'localhost') . ';dbname=' . ($info['db_database'] ?: ''),
        $info['db_username'] ?: 'root',
        getenv('DB_PASSWORD') ?: ''
    );
    $info['database_connection'] = 'OK';
    $info['database_tables'] = $pdo->query('SHOW TABLES')->rowCount();
} catch (Exception $e) {
    $info['database_connection'] = 'ERROR: ' . $e->getMessage();
}

echo json_encode($info, JSON_PRETTY_PRINT);
