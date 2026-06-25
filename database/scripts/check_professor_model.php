<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$table = App\Models\Professor::query()->getModel()->getTable();
echo "Table: {$table}\n";
echo "Count: " . App\Models\Professor::count() . "\n";
