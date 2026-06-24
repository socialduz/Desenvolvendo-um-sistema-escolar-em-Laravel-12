<?php

/**
 * Testes do módulo Usuário contra o app Laravel (banco real do .env).
 * Uso: php database/scripts/test_usuario.php
 */

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
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

function loginAsTestUser($kernel, App\Models\User $user, string $password): array
{
    $loginPage = requestPage($kernel, 'GET', '/login');
    $login = requestPage($kernel, 'POST', '/login', [
        '_token' => $loginPage['csrf'],
        'email' => $user->email,
        'password' => $password,
    ], $loginPage['cookies']);

    return [
        'ok' => in_array($login['status'], [302, 303], true),
        'cookies' => $login['cookies'],
        'location' => $login['location'],
    ];
}

function validUserPayload(string $suffix): array
{
    return [
        'name' => "Usuario Teste Auto {$suffix}",
        'email' => "usuario.auto.{$suffix}@teste.local",
        'password' => 'senha12345',
        'rg' => "RG{$suffix}",
        'cpf' => "CPF{$suffix}",
        'status' => 1,
        'endereco' => 'Rua Teste, 100',
        'complemento' => 'Apto 1',
        'bairro' => 'Centro',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'telefone' => '11999999999',
        'observacao' => 'Criado pelo script de teste',
    ];
}

echo "========== TESTES MÓDULO USUÁRIO ==========\n\n";

// 1. Rota protegida — visitante deve ir para login
$guestIndex = requestPage($kernel, 'GET', '/usuario');
$guestRedirectOk = in_array($guestIndex['status'], [302, 303], true)
    && str_contains((string) $guestIndex['location'], 'login');
record($report, 'Visitante em /usuario redireciona para login', $guestRedirectOk, 'Status '.$guestIndex['status'].' → '.($guestIndex['location'] ?? 'sem location'));

// Usuário temporário só para autenticação — não altera contas existentes
$authSuffix = (string) time();
$authPassword = 'senha-auth-auto-'.$authSuffix;
$authUser = App\Models\User::query()->create(array_merge(validUserPayload('auth-'.$authSuffix), [
    'email' => "auth.auto.{$authSuffix}@teste.local",
    'password' => $authPassword,
]));

if (! $authUser) {
    record($report, 'Usuário temporário para autenticação', false, 'Não foi possível criar usuário de teste');
} else {
    record($report, 'Usuário temporário para autenticação', true, $authUser->email);

    $session = loginAsTestUser($kernel, $authUser, $authPassword);
    record($report, 'Login do usuário de teste', $session['ok'], (string) ($session['location'] ?? ''));

    if ($session['ok']) {
        $cookies = $session['cookies'];

        // 2. Listagem autenticada
        $index = requestPage($kernel, 'GET', '/usuario', [], $cookies);
        record($report, 'GET /usuario autenticado (index)', $index['status'] === 200, (string) $index['status']);

        // 3. Formulário create
        $create = requestPage($kernel, 'GET', '/usuario/create', [], $cookies);
        $createOk = $create['status'] === 200
            && str_contains($create['body'], 'Cadastrar Usuário')
            && str_contains($create['body'], 'name="name"');
        record($report, 'GET /usuario/create (formulário)', $createOk, (string) $create['status']);

        // 4. Validação — campos vazios
        $invalidStore = requestPage($kernel, 'POST', '/usuario', [
            '_token' => $create['csrf'],
        ], $cookies);
        $validationRedirect = in_array($invalidStore['status'], [302, 303], true);
        $validationPage = requestPage(
            $kernel,
            'GET',
            (string) ($validationRedirect ? $invalidStore['location'] : '/usuario/create'),
            [],
            $invalidStore['cookies']
        );
        $validationOk = $validationRedirect
            && str_contains($validationPage['body'], 'O nome é obrigatório')
            && str_contains($validationPage['body'], 'O e-mail é obrigatório');
        record($report, 'POST /usuario sem dados (validação)', $validationOk, 'Status '.$invalidStore['status']);

        // 5. Cadastro com sucesso
        $suffix = (string) time();
        $payload = validUserPayload($suffix);
        $create2 = requestPage($kernel, 'GET', '/usuario/create', [], $cookies);
        $store = requestPage($kernel, 'POST', '/usuario', array_merge($payload, [
            '_token' => $create2['csrf'],
        ]), $create2['cookies']);

        $storeRedirectOk = in_array($store['status'], [302, 303], true);
        $indexAfterStore = $storeRedirectOk
            ? requestPage($kernel, 'GET', (string) $store['location'], [], $store['cookies'])
            : ['body' => '', 'status' => 0];

        $created = App\Models\User::query()->where('email', $payload['email'])->first();
        $storeOk = $storeRedirectOk
            && $created !== null
            && str_contains($indexAfterStore['body'], 'Usuário cadastrado com sucesso');
        record($report, 'POST /usuario cadastro válido (store)', $storeOk, 'Status '.$store['status'].($created ? '' : ' — registro não encontrado no banco'));

        // 6. E-mail duplicado
        if ($created) {
            $create3 = requestPage($kernel, 'GET', '/usuario/create', [], $cookies);
            $dupStore = requestPage($kernel, 'POST', '/usuario', array_merge($payload, [
                '_token' => $create3['csrf'],
                'name' => 'Outro Nome Duplicado',
            ]), $create3['cookies']);
            $dupPage = requestPage(
                $kernel,
                'GET',
                (string) $dupStore['location'],
                [],
                $dupStore['cookies']
            );
            $dupOk = in_array($dupStore['status'], [302, 303], true)
                && str_contains($dupPage['body'], 'Este e-mail já está cadastrado');
            record($report, 'POST /usuario e-mail duplicado', $dupOk, 'Status '.$dupStore['status']);
        }

        // 7. Login com usuário recém-cadastrado
        if ($created) {
            $kernel->handle(Illuminate\Http\Request::create('/logout', 'POST', [
                '_token' => $create3['csrf'] ?? $create2['csrf'],
            ], $cookies));

            $newLoginPage = requestPage($kernel, 'GET', '/login');
            $newLogin = requestPage($kernel, 'POST', '/login', [
                '_token' => $newLoginPage['csrf'],
                'email' => $payload['email'],
                'password' => $payload['password'],
            ], $newLoginPage['cookies']);

            $loginNewUserOk = in_array($newLogin['status'], [302, 303], true)
                && str_contains((string) $newLogin['location'], 'dashboard');
            record($report, 'Login com usuário cadastrado', $loginNewUserOk, (string) ($newLogin['location'] ?? ''));

            // Limpeza
            $created->delete();
            record($report, 'Limpeza do usuário de teste', ! App\Models\User::query()->where('email', $payload['email'])->exists(), $payload['email']);
        }

        // 8. Filtro na listagem
        $filter = requestPage($kernel, 'GET', '/usuario?pesquisar=1&name='.urlencode($authUser->name).'&status=1', [], $cookies);
        record($report, 'GET /usuario com filtro', $filter['status'] === 200, (string) $filter['status']);

        $authUser->delete();
        record($report, 'Limpeza do usuário temporário de auth', ! App\Models\User::query()->where('id', $authUser->id)->exists(), $authUser->email);
    }
}

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
