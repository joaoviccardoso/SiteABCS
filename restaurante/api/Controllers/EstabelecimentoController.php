<?php
class EstabelecimentoController
{
    public function getEstabelecimentos()
    {
        $pdo = new Conexao();
        $qryEstab = $pdo->query('SELECT * FROM ESTABELECIMENTOS ORDER BY CODIGO');
        $qryEstab->execute();
        $estabs = $qryEstab->fetchAll(PDO::FETCH_ASSOC);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $estabs,
        ]);
    }

    public function getEstabelecimento($codigo)
    {
        $pdo = new Conexao();
        $qryEstab = $pdo->prepare('SELECT * FROM ESTABELECIMENTOS WHERE CODIGO = :codigo');
        $qryEstab->bindValue(':codigo', $codigo);
        $qryEstab->execute();
        $estab = $qryEstab->fetch(PDO::FETCH_ASSOC);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $estab,
        ]);
    }

    public function getEstabelecimentoMenuByUsuario($usuario)
    {
        $pdo = new Conexao();
        $qryEstab = $pdo->prepare('SELECT CODIGO, NOME, USUARIO FROM ESTABELECIMENTOS WHERE USUARIO = :usuario');
        $qryEstab->bindValue(':usuario', $usuario);
        $qryEstab->execute();
        $estab = $qryEstab->fetch(PDO::FETCH_ASSOC);

        $qryProd = $pdo->prepare('SELECT * FROM PRODUTOS WHERE CODESTAB = :codigo');
        $qryProd->bindValue(':codigo', $estab['CODIGO']);
        $qryProd->execute();
        $produtos = $qryProd->fetchAll(PDO::FETCH_ASSOC);

        $qryGruposProd = $pdo->prepare('SELECT * FROM GRUPO_PRODUTOS WHERE CODESTAB = :codigo');
        $qryGruposProd->bindValue(':codigo', $estab['CODIGO']);
        $qryGruposProd->execute();
        $grupos_prod = $qryGruposProd->fetchAll(PDO::FETCH_ASSOC);

        unset($pdo);

        if ($estab) {
            http_response_code(200);
            echo json_encode([
                "data" => [
                    "estab" => $estab,
                    "produtos" => $produtos,
                    "grupos_prod" => $grupos_prod,
                ],
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "message" => "Estabelecimento não encontrado",
            ]);
        }
    }

    public static function getEstabelecimentoByToken($token)
    {
        $pdo = new Conexao();
        $qryEstab = $pdo->prepare('SELECT e.CODIGO, e.NOME FROM ESTABELECIMENTOS e WHERE TOKEN = ?');
        $qryEstab->execute([$token]);
        unset($pdo);
        return $qryEstab->fetch(PDO::FETCH_ASSOC);
    }

    public function getRotas()
    {
        $pdo = new Conexao();
        $qryEstabsUsuario = $pdo->prepare('SELECT USUARIO FROM ESTABELECIMENTOS');
        $qryEstabsUsuario->execute();
        $estabs_usuario = $qryEstabsUsuario->fetchAll(PDO::FETCH_COLUMN);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $estabs_usuario,
        ]);
    }

    public function getCardapio($codigo)
    {
        $pdo = new Conexao();

        $qryProd = $pdo->prepare('SELECT * FROM PRODUTOS WHERE CODESTAB = :codigo');
        $qryProd->bindValue(':codigo', $codigo);
        $qryProd->execute();
        $produtos = $qryProd->fetchAll(PDO::FETCH_ASSOC);

        $qryGruposProd = $pdo->prepare('SELECT * FROM GRUPO_PRODUTOS WHERE CODESTAB = :codigo');
        $qryGruposProd->bindValue(':codigo', $codigo);
        $qryGruposProd->execute();
        $grupos_prod = $qryGruposProd->fetchAll(PDO::FETCH_ASSOC);

        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "grupos_produtos" => $grupos_prod,
            "produtos" => $produtos,
        ]);
    }

    public function create($dados_estab)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('INSERT INTO ESTABELECIMENTOS
                (NOME, USUARIO, TOKEN) VALUES (:nome, :usuario, :token)');
        $qry->bindValue(':nome', $dados_estab['nome']);
        $qry->bindValue(':usuario', $dados_estab['usuario']);
        $qry->bindValue(':token', $dados_estab['token']);
        $qry->execute();
        unset($pdo);

        http_response_code(201);
        echo json_encode([
            "message" => 'Estabelecimento cadastrado com sucesso.',
        ]);
    }

    public function update($codigo, $dados_estab)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('UPDATE ESTABELECIMENTOS SET
                NOME = :nome, USUARIO = :usuario, TOKEN = :token
                WHERE CODIGO = :codigo');
        $qry->bindValue(':nome', $dados_estab['nome']);
        $qry->bindValue(':usuario', $dados_estab['usuario']);
        $qry->bindValue(':token', $dados_estab['token']);
        $qry->bindValue(':codigo', $dados_estab['codigo']);
        $qry->execute();
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "message" => 'Dados do estabelecimento atualizados com sucesso.',
        ]);
    }

    public function delete($codigo)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('DELETE FROM ESTABELECIMENTOS
                WHERE CODIGO = :codigo');
        $qry->bindValue(':codigo', $codigo);
        $qry->execute();
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "message" => 'Dados do estabelecimento excluídos com sucesso.',
        ]);
    }
}
