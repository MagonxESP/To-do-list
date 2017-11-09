<?php

$confFile = ($_SERVER['SERVER_ADDR'] == '127.0.0.1')? 'localconf.ini' : 'conf.ini';

$conf = parse_ini_file($confFile);

$host = $conf['host'];
$user = $conf['user'];
$pass = $conf['password'];
$database = $conf['db'];

$db = new mysqli($host, $user, $pass, $database);

function conectar() {
  $db = new mysqli($host, $user, $pass, $database);
  return $db;
}

function ejecutar(string $query, mysqli $db) {
  $result = $db->query($query);

  if(!$result) {
    throw new Exception($db->error);
    return false;
  }

  return $result;
}


?>
