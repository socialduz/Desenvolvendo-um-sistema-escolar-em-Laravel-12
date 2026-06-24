<?php

require __DIR__.'/../../vendor/autoload.php';

$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
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

$user = App\Models\User::query()->orderBy('id')->first();
if (! $user) {
    echo "Nenhum usuário no banco.\n";
    exit(1);
}

echo "Testando edit para usuario ID: {$user->id}\n";

$loginPage = requestPage($kernel, 'GET', '/login');
$login = requestPage($kernel, 'POST', '/login', [
    '_token' => $loginPage['csrf'],
    'email' => 'admin@teste.com',
    'password' => '12345678',
], $loginPage['cookies']);

echo "Login status: {$login['status']} -> {$login['location']}\n";

$edit = requestPage($kernel, 'GET', "/usuario/{$user->id}/edit", [], $login['cookies']);
echo "Edit status: {$edit['status']}\n";
echo "Location: ".($edit['location'] ?? 'n/a')."\n";
echo "Has title: ".(str_contains($edit['body'], 'Editar Usuário') ? 'yes' : 'no')."\n";

if ($edit['status'] !== 200) {
    echo "\n--- Body snippet ---\n";
    echo substr(strip_tags($edit['body']), 0, 800)."\n";
}

if (preg_match('/class="exception-message"[^>]*>([^<]+)/', $edit['body'], $m)) {
    echo "\nException: {$m[1]}\n";
}

exit($edit['status'] === 200 ? 0 : 1);
