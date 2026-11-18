<?php
class GrupoProdutosController
{
    public static function create($descricao, $cod_estab)
    {
        $pdo = new Conexao();
        $qryInsertGrupo = $pdo->prepare('INSERT INTO GRUPO_PRODUTOS (DESCRICAO, CODESTAB)
                    VALUES (:descricao, :codestab)');
        $qryInsertGrupo->bindValue(':descricao', $descricao);
        $qryInsertGrupo->bindValue(':codestab', $cod_estab);
        $qryInsertGrupo->execute();
        unset($pdo);
    }

    public static function getGrupoProdutoByCodEstab($cod_estab)
    {
        $pdo = new Conexao();
        $qryGruposProd = $pdo->prepare('SELECT * FROM GRUPO_PRODUTOS WHERE CODESTAB = ?');
        $qryGruposProd->execute([$cod_estab]);
        unset($pdo);
        return $qryGruposProd->fetchAll(PDO::FETCH_ASSOC);
    }
}
