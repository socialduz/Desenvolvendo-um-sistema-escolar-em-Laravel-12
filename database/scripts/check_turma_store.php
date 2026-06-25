<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Turma;

echo 'Total turmas: ' . Turma::count() . PHP_EOL;

$recent = Turma::query()->orderByDesc('id')->limit(5)->get(['id', 'nome', 'descricao', 'id_escola', 'id_professor']);

echo "Ultimas 5 turmas:\n";
foreach ($recent as $t) {
    echo "  id={$t->id} nome={$t->nome} escola={$t->id_escola} professor=" . ($t->id_professor ?? 'null') . PHP_EOL;
}

$turmaK = Turma::query()->whereRaw('LOWER(nome) LIKE ?', ['%turma k%'])->first();
echo $turmaK
    ? "Turma K: id={$turmaK->id} nome={$turmaK->nome}\n"
    : "Turma K: nao encontrada\n";
