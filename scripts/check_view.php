<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Boot minimal kernel to initialize container
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// Bootstrap the application so service providers and helpers are registered
$kernel->bootstrap();
// Set theme and check view
try {
    themes()->set(config('themes.shop-default'));
    $exists = app('view')->exists('shop::layouts.master');
    echo $exists ? "FOUND\n" : "MISSING\n";
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

