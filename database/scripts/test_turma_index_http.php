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

$response = $kernel->handle(Illuminate\Http\Request::create('/turma', 'GET', [], $cookies));
$body = (string) $response->getContent();

echo "Status: {$response->getStatusCode()}\n";
echo "Listar Turmas: " . (str_contains($body, 'Listar Turmas') ? 'SIM' : 'NAO') . "\n";
echo "Total turmas no banco: " . App\Models\Turma::count() . "\n";
