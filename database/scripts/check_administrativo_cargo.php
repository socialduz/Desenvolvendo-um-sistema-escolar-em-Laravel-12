<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Administrativo;
use App\Models\Cargo;

echo "=== CARGOS ===\n";
echo Cargo::count() . " registros\n\n";

echo "=== ADMINISTRATIVOS ===\n";
foreach (Administrativo::with(['usuario', 'escola', 'cargo'])->get() as $a) {
    $cargoTitulo = $a->cargo?->titulo ?? 'NULL (relacionamento falhou)';
    echo "id={$a->id} | usuario={$a->usuario?->name} | escola={$a->escola?->razao_social} | id_cargo={$a->id_cargo} | cargo={$cargoTitulo}\n";
    echo "  attrs: " . json_encode($a->getAttributes()) . "\n";
}

$cols = DB::select("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'administrativo' ORDER BY ordinal_position");
echo "\n=== COLUNAS administrativo ===\n";
foreach ($cols as $c) {
    echo "  {$c->column_name} ({$c->data_type})\n";
}

$colsCargo = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'cargo' ORDER BY ordinal_position");
echo "\n=== COLUNAS cargo ===\n";
echo implode(', ', array_column($colsCargo, 'column_name')) . "\n";
