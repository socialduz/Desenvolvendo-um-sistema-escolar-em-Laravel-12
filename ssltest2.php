<?php
$host='roundhouse.proxy.rlwy.net'; $port=11508; $db='railway';
$user='root'; $pass='cwgRbdjKrPKiaDmHSbzaqGysQfulySVf';
$dsn="mysql:host=$host;port=$port;dbname=$db";

function tryit($name,$dsn,$user,$pass,$opts){
  try { $opts[PDO::ATTR_TIMEOUT]=15; $p=new PDO($dsn,$user,$pass,$opts);
    $c=$p->query("SELECT @@ssl_cipher c, VERSION() v")->fetch(PDO::FETCH_ASSOC);
    echo "[OK]   $name | ver={$c['v']} cipher=".($c['c']?:'(none)').PHP_EOL; return true;
  } catch(Throwable $e){ echo "[FAIL] $name | ".$e->getMessage().PHP_EOL; return false; }
}

// E: força SSL passando uma cipher list (ativa SSL sem precisar de CA file)
tryit('E: SSL via ATTR_SSL_VERIFY=false + empty CA path', $dsn,$user,$pass,[
  PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=>false,
]);

// F: DSN sem dbname (as vezes selecionar schema no handshake causa o drop)
$dsn2="mysql:host=$host;port=$port";
tryit('F: sem dbname no DSN', $dsn2,$user,$pass,[]);

// G: usar 127.0.0.1 forçando TCP + SSL key set
if (defined('PDO::MYSQL_ATTR_SSL_KEY')) echo "SSL_KEY const exists\n";
