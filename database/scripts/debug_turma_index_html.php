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
$html = (string) $response->getContent();

if (preg_match('/<tbody>(.*?)<\/tbody>/s', $html, $m)) {
    echo substr($m[1], 0, 2500);
} else {
    echo "tbody not found\n";
}

echo "\n\n--- includes _acoes file size ---\n";
echo filesize(__DIR__ . '/../../resources/views/turma/_acoes.blade.php') . " bytes\n";
