<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== USERS ===\n";
foreach (DB::table('users')->orderBy('id')->get() as $u) {
    echo "  id={$u->id} | {$u->name} | {$u->email}\n";
}

echo "\n=== PROFESSOR (colunas) ===\n";
$cols = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'professor' ORDER BY ordinal_position");
echo implode(', ', array_column($cols, 'column_name')) . "\n";

echo "\n=== PROFESSOR (dados) ===\n";
$rows = DB::table('professor')->orderBy('id')->get();
if ($rows->isEmpty()) {
    echo "  (vazio)\n";
} else {
    foreach ($rows as $p) {
        echo "  id={$p->id} | id_usuario=" . ($p->id_usuario ?? $p->id_pessoa ?? '?') . " | id_escola={$p->id_escola}\n";
    }
}

echo "\n=== TURMA (id_professor) ===\n";
$turmas = DB::table('turma')->select('id', 'id_professor')->orderBy('id')->limit(15)->get();
foreach ($turmas as $t) {
    echo "  turma id={$t->id} | id_professor={$t->id_professor}\n";
}
