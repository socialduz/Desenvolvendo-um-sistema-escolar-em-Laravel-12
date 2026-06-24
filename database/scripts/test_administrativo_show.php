<?php

/**
 * Testes Aula 4 — Visualização de Administrativo.
 * Uso: php database/scripts/test_administrativo_show.php
 */

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$report = [];

function record(array &$report, string $action, bool $passed, string $detail = ''): void
{
    $report[] = compact('action', 'passed', 'detail');
}

function requestPage($kernel, string $method, string $uri, array $data = [], array $cookies = []): array
{
    $response = $kernel->handle(Illuminate\Http\Request::create($uri, $method, $data, $cookies));

    $newCookies = $cookies;
    foreach ($response->headers->getCookies() as $cookie) {
        $newCookies[$cookie->getName()] = $cookie->getValue();
    }

    preg_match('/name="_token" value="([^"]+)"/', (string) $response->getContent(), $matches);

    return [
        'status' => $response->getStatusCode(),
        'body' => (string) $response->getContent(),
        'cookies' => $newCookies,
        'csrf' => $matches[1] ?? null,
    ];
}

$loginPage = requestPage($kernel, 'GET', '/login');
$login = requestPage($kernel, 'POST', '/login', [
    '_token' => $loginPage['csrf'],
    'email' => 'admin@teste.com',
    'password' => '12345678',
], $loginPage['cookies']);

$cookies = $login['cookies'];
record($report, 'Login', in_array($login['status'], [302, 303], true));

$admin = App\Models\Administrativo::query()->with(['usuario', 'escola', 'cargo'])->first();

if (! $admin) {
    record($report, 'Registro administrativo', false, 'Nenhum registro no banco');
} else {
    $show = requestPage($kernel, 'GET', "/administrativo/{$admin->id}", [], $cookies);
    record(
        $report,
        'GET /administrativo/{id} (show)',
        $show['status'] === 200
            && str_contains($show['body'], 'Visualizar Administrativo')
            && str_contains($show['body'], $admin->usuario->name)
            && str_contains($show['body'], $admin->escola->razao_social)
            && str_contains($show['body'], $admin->cargo->titulo)
            && ! str_contains($show['body'], 'administrativo.update'),
        (string) $show['status']
    );

    $edit = requestPage($kernel, 'GET', "/administrativo/{$admin->id}/edit", [], $cookies);
    record(
        $report,
        'GET /administrativo/{id}/edit',
        $edit['status'] === 200
            && str_contains($edit['body'], 'Editar Administrativo')
            && str_contains($edit['body'], 'name="id_cargo"')
            && str_contains($edit['body'], $admin->cargo->titulo),
        (string) $edit['status']
    );

    $index = requestPage($kernel, 'GET', '/administrativo', [], $cookies);
    record(
        $report,
        'GET /administrativo (index)',
        $index['status'] === 200
            && str_contains($index['body'], $admin->cargo->titulo),
        (string) $index['status']
    );
}

$dashboard = requestPage($kernel, 'GET', '/dashboard', [], $cookies);
record(
    $report,
    'Sidebar com link Administrativo',
    str_contains($dashboard['body'], route('administrativo.index', [], false))
        && str_contains($dashboard['body'], 'Administrativo'),
    'dashboard'
);

echo "========== TESTES AULA 4 — ADMINISTRATIVO ==========\n\n";
$ok = 0;
$fail = 0;
foreach ($report as $row) {
    $icon = $row['passed'] ? 'OK  ' : 'FALHA';
    $detail = $row['detail'] ? " — {$row['detail']}" : '';
    echo "[{$icon}] {$row['action']}{$detail}\n";
    $row['passed'] ? $ok++ : $fail++;
}
echo "====================================================\n";
echo "Total: ".count($report)." | OK: {$ok} | Falhas: {$fail}\n";

exit($fail > 0 ? 1 : 0);
