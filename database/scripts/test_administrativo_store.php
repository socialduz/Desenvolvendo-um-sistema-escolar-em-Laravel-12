<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Administrativo;
use App\Models\User;
use App\Models\Escola;
use App\Models\Cargo;

$user = User::query()->first();
$escola = Escola::query()->first();
$cargo = Cargo::query()->first();

if (! $user || ! $escola || ! $cargo) {
    echo "Dados insuficientes para teste.\n";
    exit(1);
}

try {
    $admin = Administrativo::create([
        'id_usuario' => $user->id,
        'id_escola' => $escola->id,
        'id_cargo' => $cargo->id,
    ]);
    echo "OK - id={$admin->id}\n";
} catch (Throwable $e) {
    echo "ERRO: {$e->getMessage()}\n";
    exit(1);
}
