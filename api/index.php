<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Force SCRIPT_NAME to /index.php so routing & redirects work properly on Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Ensure /tmp directories exist for Vercel's read-only serverless environment
$tmpDirs = [
    '/tmp/views',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/logs',
];
foreach ($tmpDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
