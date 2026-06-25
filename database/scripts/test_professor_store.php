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

$createPage = $kernel->handle(Illuminate\Http\Request::create('/professor/create', 'GET', [], $cookies));
preg_match('/name="_token" value="([^"]+)"/', (string) $createPage->getContent(), $m2);

$userId = (int) DB::table('users')->where('email', 'admin@teste.com')->value('id');
$escolaId = (int) DB::table('escola')->orderBy('id')->value('id');

$request = Illuminate\Http\Request::create('/professor', 'POST', [
    '_token' => $m2[1],
    'id_usuario' => $userId,
    'id_escola' => $escolaId,
    'registro' => 'TEST-' . time(),
    'salario' => '3000',
    'status' => '1',
    'data_cadastro' => date('Y-m-d'),
    'observacao' => 'Teste script',
], $cookies);
$response = $kernel->handle($request);

echo "Status: {$response->getStatusCode()}\n";
if ($response->isRedirect()) {
    echo "Redirect: {$response->headers->get('Location')}\n";
}
$alerta = session('alerta');
echo 'Alerta: ' . json_encode($alerta, JSON_UNESCAPED_UNICODE) . "\n";

$kernel->terminate($request, $response);
