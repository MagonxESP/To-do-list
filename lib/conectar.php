<?php

$confFile = ($_SERVER['SERVER_ADDR'] == '127.0.0.1')? 'localconf.ini' : 'conf.ini';

$conf = parse_ini_file($confFile);

$host = $conf['host'];
$user = $conf['user'];
$pass = $conf['password'];
$database = $conf['db'];

$db = new mysqli($host, $user, $pass, $database);

?>
