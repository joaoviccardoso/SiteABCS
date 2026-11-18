<?php
    class Conexao extends PDO{
        public function __construct($file = 'conexao.ini'){
            if (!$settings = parse_ini_file($file, TRUE)) throw new  exception('Não foi possível abrir ' . $file . '.');

            // Configurações do DNS
            $d = $settings['driver'];
            $h = $settings['host'];  
            $p = $settings['port'];  
            $db = $settings['dbname'];

            $dsn = "$d:host=$h;port=$p;dbname=$db;";

            $user = $settings['user'];
            $pass = $settings['pass'];
            $options = $settings['options'];

            parent::__construct($dsn, $user, $pass, $options);    
        }
    }
?>