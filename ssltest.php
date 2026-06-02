<?php
$host='roundhouse.proxy.rlwy.net'; $port=11508; $db='railway';
$user='root'; $pass='cwgRbdjKrPKiaDmHSbzaqGysQfulySVf';
$dsn="mysql:host=$host;port=$port;dbname=$db";

$tests = [
  'A: no ssl options' => [],
  'B: VERIFY_SERVER_CERT=false only' => [PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false],
  'C: SSL_CA=true + verify=false' => [PDO::MYSQL_ATTR_SSL_CA => true, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false],
  'D: SSL_CA empty-string + verify=false' => [PDO::MYSQL_ATTR_SSL_CA => '', PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false],
];
foreach ($tests as $name => $opts) {
  try {
    $opts[PDO::ATTR_TIMEOUT] = 10;
    $pdo = new PDO($dsn, $user, $pass, $opts);
    $cipher = $pdo->query("SHOW SESSION STATUS LIKE 'Ssl_cipher'")->fetch(PDO::FETCH_ASSOC);
    echo "[OK]   $name | Ssl_cipher=" . ($cipher['Value'] ?: '(none)') . PHP_EOL;
  } catch (Throwable $e) {
    echo "[FAIL] $name | " . $e->getMessage() . PHP_EOL;
  }
}
