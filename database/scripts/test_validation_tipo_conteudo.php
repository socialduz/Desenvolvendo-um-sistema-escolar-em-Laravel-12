<?php

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

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

$create = requestPage($kernel, 'GET', '/tipo-conteudo/create');
$store = requestPage($kernel, 'POST', '/tipo-conteudo', [
    '_token' => $create['csrf'],
    'tipo' => '',
    'status' => '',
], $create['cookies']);

$page = requestPage($kernel, 'GET', (string) $store['location'], [], $store['cookies']);

foreach ([
    'O tipo de conteúdo é obrigatório',
    'O status é obrigatório',
    'invalid-feedback',
] as $needle) {
    echo (str_contains($page['body'], $needle) ? 'OK' : 'FALHOU').': '.$needle.PHP_EOL;
}
