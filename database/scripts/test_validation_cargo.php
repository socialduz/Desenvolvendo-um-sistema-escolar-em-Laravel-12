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

$create = requestPage($kernel, 'GET', '/cargo/create');
$store = requestPage($kernel, 'POST', '/cargo', [
    '_token' => $create['csrf'],
    'titulo' => '',
    'descricao' => '',
    'status' => '',
], $create['cookies']);

echo 'POST status: '.$store['status'].PHP_EOL;
echo 'Redirect: '.$store['location'].PHP_EOL;

$page = requestPage($kernel, 'GET', (string) $store['location'], [], $store['cookies']);

foreach ([
    'O título do cargo é obrigatório',
    'A descrição do cargo é obrigatória',
    'O status é obrigatório',
    'alert-danger',
    'invalid-feedback',
    'is-invalid',
] as $needle) {
    echo (str_contains($page['body'], $needle) ? 'OK' : 'FALHOU').': '.$needle.PHP_EOL;
}
