<?php
    class Token{
        // Query para verificar se existem estabelecimentos com esse token no banco de dados.
        private static function estabelecimentoTokenCheck($token){
            $pdo = new Conexao();
        
            $qryEstab = $pdo->prepare('SELECT count(*) as countEstabelecimentos FROM ESTABELECIMENTOS WHERE TOKEN = :Token');
            $qryEstab->bindValue(':Token', $token);
            $qryEstab->execute();
            unset($pdo);
            $estab = $qryEstab->fetch(PDO::FETCH_ASSOC);
            return $estab['countEstabelecimentos'] != 0;
        }

        // Query para verificar se existem logins com esse token no banco de dados.
        private static function loginsTokenCheck($token){
            $pdo = new Conexao();
            $qryLogins = $pdo->prepare('SELECT count(*) as countLogins FROM LOGINS WHERE TOKEN = :Token');
            $qryLogins->bindValue(':Token', $token);
            $qryLogins->execute();
            unset($pdo);
            $login = $qryLogins->fetch(PDO::FETCH_ASSOC);
            return $login['countLogins'] != 0;
        }

        // Função que usa as querys acima para verificar se o token é válido.
        public static function check($token){
            return (self::loginsTokenCheck($token) ||
                self::estabelecimentoTokenCheck($token));
        }
    }

?>