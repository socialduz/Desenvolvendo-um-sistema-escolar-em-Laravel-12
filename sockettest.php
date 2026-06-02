<?php
$host='roundhouse.proxy.rlwy.net'; $port=11508;
$fp = @fsockopen($host, $port, $errno, $errstr, 10);
if (!$fp) { echo "fsockopen failed: $errno $errstr\n"; exit(1); }
stream_set_timeout($fp, 10);
$data = fread($fp, 200);
$meta = stream_get_meta_data($fp);
echo "bytes read: " . strlen($data) . PHP_EOL;
echo "timed_out: " . ($meta['timed_out'] ? 'yes':'no') . PHP_EOL;
echo "eof: " . ($meta['eof'] ? 'yes':'no') . PHP_EOL;
if (strlen($data) > 0) {
  // primeiros bytes = packet length(3) + seq(1) + protocol version(1) + server version (null-term string)
  $proto = ord($data[4]);
  echo "protocol version byte: $proto" . PHP_EOL;
  $ver = substr($data, 5);
  $ver = substr($ver, 0, strpos($ver, "\0"));
  echo "server version: $ver" . PHP_EOL;
  echo "hex(first 16): " . bin2hex(substr($data,0,16)) . PHP_EOL;
}
fclose($fp);
