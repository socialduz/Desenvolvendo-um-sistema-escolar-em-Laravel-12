<?php

/**
 * Testes de edição/atualização do módulo Usuário.
 * Uso: php database/scripts/test_usuario_update.php
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

function login($kernel): ?array
{
    $loginPage = requestPage($kernel, 'GET', '/login');
    $login = requestPage($kernel, 'POST', '/login', [
        '_token' => $loginPage['csrf'],
        'email' => 'admin@teste.com',
        'password' => '12345678',
    ], $loginPage['cookies']);

    if (! in_array($login['status'], [302, 303], true)) {
        return null;
    }

    return $login['cookies'];
}

echo "========== TESTES UPDATE USUÁRIO ==========\n\n";

$cookies = login($kernel);
record($report, 'Login admin@teste.com', $cookies !== null, $cookies ? 'OK' : 'Falhou');

if (! $cookies) {
    foreach ($report as $row) {
        echo '['.($row['passed'] ? 'OK  ' : 'FALHA').'] '.$row['action']."\n";
    }
    exit(1);
}

$target = App\Models\User::query()->where('email', 'admin@teste.com')->first();
if (! $target) {
    record($report, 'Usuário alvo admin@teste.com', false, 'Não encontrado');
    exit(1);
}

$originalPassword = $target->password;
$originalName = $target->name;
$originalCidade = $target->cidade;

// 1. Tela de edição
$edit = requestPage($kernel, 'GET', "/usuario/{$target->id}/edit", [], $cookies);
record(
    $report,
    'GET /usuario/{id}/edit',
    $edit['status'] === 200 && str_contains($edit['body'], 'Editar Usuário'),
    (string) $edit['status']
);

// 2. Update sem alterar senha
$newName = 'Admin Teste Atualizado '.time();
$newCidade = 'Campinas';
$updateData = [
    '_token' => $edit['csrf'],
    '_method' => 'PUT',
    'name' => $newName,
    'email' => $target->email,
    'password' => '',
    'rg' => $target->rg ?? '1234567',
    'cpf' => $target->cpf ?? '12345678901',
    'status' => $target->status ?? 1,
    'endereco' => $target->endereco ?? 'Rua Teste, 1',
    'complemento' => $target->complemento ?? '',
    'bairro' => $target->bairro ?? 'Centro',
    'cidade' => $newCidade,
    'estado' => $target->estado ?? 'SP',
    'telefone' => $target->telefone ?? '11999999999',
    'observacao' => $target->observacao ?? '',
];

$update = requestPage($kernel, 'POST', "/usuario/{$target->id}", $updateData, $cookies);
$indexAfter = in_array($update['status'], [302, 303], true)
    ? requestPage($kernel, 'GET', (string) $update['location'], [], $update['cookies'])
    : ['body' => '', 'status' => 0];

$target->refresh();
$updateOk = in_array($update['status'], [302, 303], true)
    && str_contains((string) $update['location'], '/usuario')
    && ! str_contains((string) $update['location'], '/edit')
    && $target->name === $newName
    && $target->cidade === $newCidade
    && $target->password === $originalPassword;

$detail = 'Status '.$update['status']
    .' | loc='.($update['location'] ?? 'n/a')
    .' | name='.($target->name === $newName ? 'ok' : 'diff')
    .' | cidade='.($target->cidade === $newCidade ? 'ok' : 'diff')
    .' | pass='.($target->password === $originalPassword ? 'ok' : 'diff');

record($report, 'PUT update sem senha (mantém hash)', $updateOk, $detail);

// 3. Login ainda funciona com senha antiga
$kernel->handle(Illuminate\Http\Request::create('/logout', 'POST', ['_token' => $edit['csrf']], $cookies));
$loginPage2 = requestPage($kernel, 'GET', '/login');
$login2 = requestPage($kernel, 'POST', '/login', [
    '_token' => $loginPage2['csrf'],
    'email' => 'admin@teste.com',
    'password' => '12345678',
], $loginPage2['cookies']);

record(
    $report,
    'Login após update sem trocar senha',
    in_array($login2['status'], [302, 303], true) && str_contains((string) $login2['location'], 'dashboard'),
    (string) ($login2['location'] ?? '')
);

$cookies2 = $login2['cookies'];

// 4. Update com nova senha
$edit2 = requestPage($kernel, 'GET', "/usuario/{$target->id}/edit", [], $cookies2);
$newPassword = 'novaSenha99';
$updateData['name'] = $newName;
$updateData['password'] = $newPassword;
$updateData['_token'] = $edit2['csrf'];

$update2 = requestPage($kernel, 'POST', "/usuario/{$target->id}", $updateData, $edit2['cookies']);
$target->refresh();
$passwordChanged = $target->password !== $originalPassword;

record($report, 'PUT update com nova senha', in_array($update2['status'], [302, 303], true) && $passwordChanged, 'Status '.$update2['status']);

// 5. Login com nova senha
$kernel->handle(Illuminate\Http\Request::create('/logout', 'POST', ['_token' => $edit2['csrf']], $cookies2));
$loginPage3 = requestPage($kernel, 'GET', '/login');
$login3 = requestPage($kernel, 'POST', '/login', [
    '_token' => $loginPage3['csrf'],
    'email' => 'admin@teste.com',
    'password' => $newPassword,
], $loginPage3['cookies']);

record(
    $report,
    'Login com nova senha',
    in_array($login3['status'], [302, 303], true) && str_contains((string) $login3['location'], 'dashboard'),
    (string) ($login3['location'] ?? '')
);

// Restaurar dados do admin de teste
$target->update([
    'name' => $originalName,
    'cidade' => $originalCidade,
    'password' => '12345678',
]);
record($report, 'Restaurar usuário admin de teste', true, 'admin@teste.com / 12345678');

echo "\n========== RELATÓRIO ==========\n";
$ok = 0;
$fail = 0;
foreach ($report as $row) {
    $icon = $row['passed'] ? 'OK  ' : 'FALHA';
    $detail = $row['detail'] ? " — {$row['detail']}" : '';
    echo "[{$icon}] {$row['action']}{$detail}\n";
    $row['passed'] ? $ok++ : $fail++;
}
echo "==============================\n";
echo "Total: ".count($report)." | OK: {$ok} | Falhas: {$fail}\n";

exit($fail > 0 ? 1 : 0);
