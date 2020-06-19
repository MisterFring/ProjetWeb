<?php
 
define('MYSQL_USER', 'dbu293874'); 
define('MYSQL_PASSWORD', '76Uh?mV5@'); 
define('MYSQL_HOST', 'db5000527661.hosting-data.io'); 
define('MYSQL_DATABASE', 'dbs506520');

$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);
 
$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, //Username
    MYSQL_PASSWORD, //Password
    $pdoOptions //Options
);
?>