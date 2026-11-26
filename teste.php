<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "IP de saida da Hostinger: " . @file_get_contents('https://api.ipify.org') . "<br>";

$f = @fsockopen('186.233.20.174', 80, $errno, $errstr, 5);
echo $f ? "Conexao OK" : "Falhou: $errno - $errstr";