<?php
$host='roundhouse.proxy.rlwy.net'; $port=11508; $db='railway';
$user='root'; $pass='cwgRbdjKrPKiaDmHSbzaqGysQfulySVf';
$dsn="mysql:host=$host;port=$port;dbname=$db";

$tests = [
  'GET_SERVER_PUBLIC_KEY=true' => [PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, 1031 => true], // 1031 = MYSQL_ATTR_SSL? no
];
// usar nome real da constante
$opts = [];
if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
echo "PDO::MYSQL_ATTR_SSL_CA exists: " . (defined('PDO::MYSQL_ATTR_SSL_CA')?'yes':'no') . PHP_EOL;

// Tentar com retry simples — a falha do greeting pode ser intermitente
for ($i=1; $i<=5; $i++) {
  try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_TIMEOUT=>15]);
    $r = $pdo->query("SELECT VERSION() v, @@ssl_cipher c")->fetch(PDO::FETCH_ASSOC);
    echo "[OK] attempt $i | version={$r['v']} ssl_cipher=".($r['c']?:'(none)').PHP_EOL;
    $a = $pdo->query("SELECT plugin FROM mysql.user WHERE user='root' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    echo "auth plugin: ".($a['plugin']??'?').PHP_EOL;
    exit;
  } catch (Throwable $e) {
    echo "[fail $i] ".$e->getMessage().PHP_EOL;
  }
}
