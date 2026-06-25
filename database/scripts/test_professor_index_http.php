<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$loginPage = $kernel->handle(Illuminate\Http\Request::create('/login', 'GET'));
preg_match('/name="_token" value="([^"]+)"/', (string) $loginPage->getContent(), $m);
$cookies = [];
foreach ($loginPage->headers->getCookies() as $c) { $cookies[$c->getName()] = $c->getValue(); }

$login = $kernel->handle(Illuminate\Http\Request::create('/login', 'POST', [
    '_token' => $m[1], 'email' => 'admin@teste.com', 'password' => '12345678',
], $cookies));
foreach ($login->headers->getCookies() as $c) { $cookies[$c->getName()] = $c->getValue(); }

$request = Illuminate\Http\Request::create('/professor', 'GET', [], $cookies);
$response = $kernel->handle($request);

echo "Status: {$response->getStatusCode()}\n";
$body = (string) $response->getContent();
if ($response->getStatusCode() >= 400) {
    echo substr($body, 0, 2000) . "\n";
} else {
    echo "Tem Listar Professores: " . (str_contains($body, 'Listar Professores') ? 'SIM' : 'NAO') . "\n";
    echo "Tem Admin Teste: " . (str_contains($body, 'Admin Teste') ? 'SIM' : 'NAO') . "\n";
    echo "Tamanho: " . strlen($body) . " bytes\n";
}

$kernel->terminate($request, $response);
