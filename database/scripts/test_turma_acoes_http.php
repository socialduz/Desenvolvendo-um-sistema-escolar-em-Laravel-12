<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

function loginKernel($kernel): array
{
    $loginPage = $kernel->handle(Illuminate\Http\Request::create('/login', 'GET'));
    preg_match('/name="_token" value="([^"]+)"/', (string) $loginPage->getContent(), $m);
    $cookies = [];
    foreach ($loginPage->headers->getCookies() as $c) {
        $cookies[$c->getName()] = $c->getValue();
    }

    $login = $kernel->handle(Illuminate\Http\Request::create('/login', 'POST', [
        '_token' => $m[1],
        'email' => 'admin@teste.com',
        'password' => '12345678',
    ], $cookies));

    foreach ($login->headers->getCookies() as $c) {
        $cookies[$c->getName()] = $c->getValue();
    }

    return $cookies;
}

$cookies = loginKernel($kernel);

$routes = ['/turma', '/turma/1', '/turma/1/edit'];

foreach ($routes as $path) {
    $response = $kernel->handle(Illuminate\Http\Request::create($path, 'GET', [], $cookies));
    $status = $response->getStatusCode();
    $body = (string) $response->getContent();
    $hasAcoes = str_contains($body, 'turma.show') || str_contains($body, '/turma/1/edit') || str_contains($body, 'btn-info');
    $hasError = str_contains($body, 'Whoops') || str_contains($body, 'Exception');
    echo "{$path} => HTTP {$status} | acoes no html: " . ($hasAcoes ? 'sim' : 'nao') . " | erro: " . ($hasError ? 'sim' : 'nao') . PHP_EOL;
}

// Check index HTML for actual hrefs
$index = $kernel->handle(Illuminate\Http\Request::create('/turma', 'GET', [], $cookies));
preg_match_all('/href="([^"]*turma[^"]*)"/', (string) $index->getContent(), $matches);
echo PHP_EOL . 'Links turma no index:' . PHP_EOL;
foreach (array_unique($matches[1] ?? []) as $link) {
    echo "  {$link}" . PHP_EOL;
}

$kernel->terminate(Illuminate\Http\Request::create('/turma', 'GET'), $index);
