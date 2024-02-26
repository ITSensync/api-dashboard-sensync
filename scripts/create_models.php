<?php

// Load file autoload.php untuk menggunakan fitur Laravel
require_once __DIR__.'/../vendor/autoload.php';

// Bootstrapping Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Daftar nama tabel yang akan dijadikan model
$tables = [
    'sparing04',
    'sparing05',
    'sparing06',
    'sparing07',
    'sparing08',
    'sparing09',
    'sparing10',
    'sparing11',
    // Tambahkan tabel lainnya di sini
];

// Loop untuk membuat model untuk setiap tabel
foreach ($tables as $table) {
    // Buat model menggunakan perintah artisan make:model
    \Artisan::call('make:model', [
        'name' => ucfirst(Str::camel($table)),
        '-m' => true, // Opsional: buat migrasi juga
    ]);
}

echo "Models created successfully.\n";
