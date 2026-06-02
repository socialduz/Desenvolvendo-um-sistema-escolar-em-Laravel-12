<?php
$host='roundhouse.proxy.rlwy.net'; $port=11508;
echo "=== socket cru, leitura com espera ===\n";
$fp=@stream_socket_client("tcp://$host:$port",$e,$es,10);
if(!$fp){echo "connect fail: $e $es\n";} else {
  stream_set_timeout($fp,8);
  $buf=''; $start=microtime(true);
  while(strlen($buf)<5 && (microtime(true)-$start)<8){
    $chunk=fread($fp,512);
    if($chunk===false||$chunk==='') { usleep(100000); if(feof($fp)){echo "EOF after ".strlen($buf)." bytes\n";break;} continue;}
    $buf.=$chunk;
  }
  echo "total bytes: ".strlen($buf)."\n";
  if(strlen($buf)>=5){ $ver=substr($buf,5); $ver=substr($ver,0,strpos($ver,"\0")); echo "server version: $ver\n"; }
  fclose($fp);
}
echo "=== mysqli ===\n";
mysqli_report(MYSQLI_REPORT_OFF);
$m=@mysqli_connect($host,'root','cwgRbdjKrPKiaDmHSbzaqGysQfulySVf','railway',$port);
if(!$m){ echo "mysqli errno ".mysqli_connect_errno().": ".mysqli_connect_error()."\n"; }
else { echo "mysqli OK: ".mysqli_get_server_info($m)."\n"; }
