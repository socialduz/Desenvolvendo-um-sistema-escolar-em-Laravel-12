<?php

/**
 * Testes finais do módulo Usuário (show, filtros, sidebar).
 * Uso: php database/scripts/test_usuario_show.php
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
        'location' => $response->headers->get('Location'),
    ];
}

$loginPage = requestPage($kernel, 'GET', '/login');
$login = requestPage($kernel, 'POST', '/login', [
    '_token' => $loginPage['csrf'],
    'email' => 'admin@teste.com',
    'password' => '12345678',
], $loginPage['cookies']);

$cookies = $login['cookies'];
record($report, 'Login', in_array($login['status'], [302, 303], true), (string) ($login['location'] ?? ''));

$user = App\Models\User::query()->where('email', 'admin@teste.com')->first();
if (! $user) {
    record($report, 'Usuário alvo', false, 'admin@teste.com não encontrado');
} else {
    $show = requestPage($kernel, 'GET', "/usuario/{$user->id}", [], $cookies);
    record(
        $report,
        'GET /usuario/{id} (show)',
        $show['status'] === 200
            && str_contains($show['body'], 'Visualizar Usuário')
            && str_contains($show['body'], $user->name)
            && str_contains($show['body'], 'Ativo')
            && ! str_contains($show['body'], 'type="password"'),
        (string) $show['status']
    );

    $filterStatus = requestPage($kernel, 'GET', '/usuario?pesquisar=1&status=1&name='.urlencode($user->name), [], $cookies);
    record(
        $report,
        'Filtro por nome + status ativo',
        $filterStatus['status'] === 200 && str_contains($filterStatus['body'], $user->email),
        (string) $filterStatus['status']
    );

    $filterEmpty = requestPage($kernel, 'GET', '/usuario?pesquisar=1&status=0&name=NomeInexistenteXYZ', [], $cookies);
    record(
        $report,
        'Filtro sem resultado',
        $filterEmpty['status'] === 200 && str_contains($filterEmpty['body'], 'Usuário não encontrado'),
        (string) $filterEmpty['status']
    );

    $dashboard = requestPage($kernel, 'GET', '/dashboard', [], $cookies);
    record(
        $report,
        'Sidebar com link Usuários',
        str_contains($dashboard['body'], route('usuario.index', [], false))
            && str_contains($dashboard['body'], 'Usuários'),
        'dashboard'
    );
}

echo "========== TESTES AULA 4 ==========\n\n";
$ok = 0;
$fail = 0;
foreach ($report as $row) {
    $icon = $row['passed'] ? 'OK  ' : 'FALHA';
    $detail = $row['detail'] ? " — {$row['detail']}" : '';
    echo "[{$icon}] {$row['action']}{$detail}\n";
    $row['passed'] ? $ok++ : $fail++;
}
echo "=================================\n";
echo "Total: ".count($report)." | OK: {$ok} | Falhas: {$fail}\n";

exit($fail > 0 ? 1 : 0);
