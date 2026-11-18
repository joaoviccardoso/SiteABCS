<?php
class LoginController
{
    // A senha virá criptografada usando bcrypt do front, e será comparada
    // com a senha do banco criptografada também.
    public function login($usuario, $senha)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('SELECT TOKEN FROM LOGINS
                WHERE USUARIO = :usuario AND SENHA = :senha');
        $qry->bindValue(':usuario', $usuario);
        $qry->bindValue(':senha', $senha);
        $qry->execute();
        $login = $qry->fetch(PDO::FETCH_ASSOC);
        unset($pdo);

        if (!empty($login)) {
            if (!isset($login["TOKEN"]) || $login["TOKEN"] == "") {
                $token = self::createToken($usuario);
            } else {
                $token = $login["TOKEN"];
            }

            http_response_code(200);
            echo json_encode([
                "token" => $token,
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => 'Usuário e/ou senha incorreto(s).',
            ]);
        }
    }

    // Função interna para atualizar os dados de login com um token.
    private function createToken($usuario)
    {
        // Utiliza a função definida em Utils/index.php para gerar um token UUID.
        $token = guidv4();

        $pdo = new Conexao();
        $qry = $pdo->prepare('UPDATE LOGINS SET
                TOKEN = :token WHERE USUARIO = :usuario');
        $qry->bindValue(':usuario', $usuario);
        $qry->bindValue(':token', $token);
        $qry->execute();
        unset($pdo);

        return $token;
    }
}
