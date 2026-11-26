<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "IP de saida: " . @file_get_contents('https://api.ipify.org') . "<br>";

$f = @fsockopen('186.233.16.211', 3306, $errno, $errstr, 5);
echo $f ? "MySQL porta 3306: OK" : "MySQL porta 3306: Falhou ($errno - $errstr)";