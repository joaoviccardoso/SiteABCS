<?php
class ProdutoController
{
    public static function create($nome, $cod_estab, $cod_grupo)
    {
        $pdo = new Conexao();
        $qryInsertProd = $pdo->prepare('INSERT INTO PRODUTOS (NOME, CODESTAB, CODGRUPO)
            VALUES (:nome, :codestab, :codgrupo)');
        $qryInsertProd->bindValue(':nome', $nome);
        $qryInsertProd->bindValue(':codestab', $cod_estab);
        $qryInsertProd->bindValue(':codgrupo', $cod_grupo);
        $qryInsertProd->execute();
        unset($pdo);
    }

    public static function getProdutosByCodEstab($cod_estab)
    {
        $pdo = new Conexao();
        $qryProd = $pdo->prepare('SELECT * FROM PRODUTOS WHERE CODESTAB = ?');
        $qryProd->execute([$cod_estab]);
        unset($pdo);
        return $qryProd->fetchAll(PDO::FETCH_ASSOC);
    }
}
