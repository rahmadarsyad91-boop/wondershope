<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // MENDAFTARKAN ALIAS SATPAM ADMIN DI SINI
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Gunakan /tmp/storage jika berjalan di Vercel (karena filesystem Vercel read-only)
if (isset($_ENV['IS_VERCEL']) && $_ENV['IS_VERCEL'] === 'true') {
    $app->useStoragePath('/tmp/storage');
    // Pastikan folder yang dibutuhkan Laravel tersedia di /tmp
    $dirs = [
        '/tmp/storage/logs',
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

return $app;