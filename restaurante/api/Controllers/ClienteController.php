<?php
class ClienteController
{
    public function getClientes()
    {
        $pdo = new Conexao();
        $qryClientes = $pdo->query('SELECT * FROM CLIENTES ORDER BY CODIGO');
        $qryClientes->execute();
        $clientes = $qryClientes->fetchAll(PDO::FETCH_ASSOC);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $clientes,
        ]);
    }

    public function getCliente($codigo)
    {
        $pdo = new Conexao();
        $qryCliente = $pdo->prepare('SELECT * FROM CLIENTES WHERE CODIGO = :codigo');
        $qryCliente->bindValue(':codigo', $codigo);
        $qryCliente->execute();
        $cliente = $qryCliente->fetch(PDO::FETCH_ASSOC);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $cliente,
        ]);
    }

    public function create($dados_cliente)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('INSERT INTO CLIENTES
                (NOME, ENDERECO, TELEFONE) VALUES
                (:nome, :endereco, :telefone)');
        $qry->bindValue(':nome', $dados_cliente['nome']);
        $qry->bindValue(':endereco', $dados_cliente['endereco']);
        $qry->bindValue(':telefone', $dados_cliente['telefone']);
        $qry->execute();
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "message" => 'Cliente cadastrado com sucesso.',
        ]);
    }

    public function update($codigo, $dados_cliente)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('UPDATE CLIENTES SET
                NOME = :nome,
                ENDERECO = :endereco,
                TELEFONE = :telefone
                WHERE CODIGO = :codigo');
        $qry->bindValue(':nome', $dados_cliente['nome']);
        $qry->bindValue(':endereco', $dados_cliente['endereco']);
        $qry->bindValue(':telefone', $dados_cliente['telefone']);
        $qry->bindValue(':codigo', $codigo);
        $qry->execute();
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "message" => 'Dados do cliente atualizados com sucesso.',
        ]);
    }

    public function delete($codigo)
    {
        $pdo = new Conexao();
        $qry = $pdo->prepare('DELETE FROM CLIENTES WHERE CODIGO = :codigo');
        $qry->bindValue(':codigo', $codigo);
        $qry->execute();
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "message" => 'Dados do cliente excluídos com sucesso.',
        ]);
    }
}
