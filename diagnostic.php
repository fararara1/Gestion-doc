<?php
header('Content-Type: application/json');

$env = file_exists(__DIR__ . '/.env') ? file_get_contents(__DIR__ . '/.env') : 'missing';

echo json_encode([
    'root' => __DIR__,
    'env_exists' => file_exists(__DIR__ . '/.env') ? 'yes' : 'no',
    'public_exists' => file_exists(__DIR__ . '/public') ? 'yes' : 'no',
    'index_exists' => file_exists(__DIR__ . '/public/index.php') ? 'yes' : 'no',
    'htaccess_exists' => file_exists(__DIR__ . '/.htaccess') ? 'yes' : 'no',
    'htaccess' => file_exists(__DIR__ . '/.htaccess') ? file_get_contents(__DIR__ . '/.htaccess') : 'missing',
    'app_url_env' => getenv('APP_URL'),
    'app_env' => getenv('APP_ENV'),
    'app_key' => getenv('APP_KEY') ? 'set' : 'missing',
]);
