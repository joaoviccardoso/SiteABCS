<?php
require_once 'GrupoProdutosController.php';
require_once 'ProdutoController.php';
require_once 'EstabelecimentoController.php';

class CargaController
{
    public function receberCarga($dados_carga)
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];

        $estabContr = new EstabelecimentoController();
        $grupoProdContr = new GrupoProdutosController();
        $prodContr = new ProdutoController();

        $data_grupos_prod = $dados_carga['grupos_prod'];
        $data_prod = $dados_carga['produtos'];

        $estab = $estabContr::getEstabelecimentoByToken($token);

        $estab_codigo = $estab['CODIGO'];

        $countGruposProd = count($grupoProdContr::getGrupoProdutoByCodEstab($estab_codigo));
        $countProd = count($prodContr::getProdutosByCodEstab($estab_codigo));

        self::verifyDataAndClean($countGruposProd, $countProd);

        self::insertGruposAndProdutos($data_grupos_prod, $data_prod, $estab_codigo);

        // Registra carga na tabela históricos de cargas.
        self::registerCargaHistory($estab_codigo, $estab['NOME'], $token);

        unset($pdo);
        unset($estabContr);
        unset($grupoProdContr);
        unset($prodContr);

        http_response_code(200);
        echo json_encode([
            "message" => 'Carga realizada com sucesso.',
        ]);
    }

    public function getHistoricoCarga()
    {
        $pdo = new Conexao();
        $qryHistoricoCarga = $pdo->query('SELECT * FROM HISTORICO_CARGA ORDER BY CODIGO DESC');
        $qryHistoricoCarga->execute();
        $cargas = $qryHistoricoCarga->fetchAll(PDO::FETCH_ASSOC);
        unset($pdo);

        http_response_code(200);
        echo json_encode([
            "data" => $cargas,
        ]);
    }

    private function registerCargaHistory($estabCod, $estabNome, $token)
    {
        $pdo = new Conexao();
        $qryHistoricoCarga = $pdo->prepare('INSERT INTO HISTORICO_CARGA (CODESTAB, NOME, TOKEN, DATACARGA) VALUES (:codEstab, :nome, :token, :dataCarga)');
        $qryHistoricoCarga->bindValue(':codEstab', $estabCod);
        $qryHistoricoCarga->bindValue(':nome', $estabNome);
        $qryHistoricoCarga->bindValue(':token', $token);
        $qryHistoricoCarga->bindValue(':dataCarga', date('Y-m-d H:i:s'));
        $qryHistoricoCarga->execute();

        unset($pdo);
    }

    private function verifyDataAndClean($countGruposProd, $countProd)
    {
        $pdo = new Conexao();

        if ($countGruposProd || $countProd) {
            if ($countGruposProd != 0) {
                $qryDeleteGrupos = $pdo->prepare('DELETE FROM GRUPO_PRODUTOS');
                $qryDeleteGrupos->execute();
            }

            if ($countProd != 0) {
                $qryDeleteProd = $pdo->prepare('DELETE FROM PRODUTOS');
                $qryDeleteProd->execute();
            }
        }

        unset($pdo);
    }

    private function insertGruposAndProdutos($data_grupos_prod, $data_prod, $cod_estab)
    {
        $pdo = new Conexao();

        $data_codigos_gp = [];
        $grupoProdContr = new GrupoProdutosController();
        foreach ($data_grupos_prod as $grupo) {
            $data_codigos_gp[] = $grupo['CODIGO'];

            $grupoProdContr::create($grupo['DESCRICAO'], $cod_estab);
        }

        $qryGruposProd = $pdo->prepare('SELECT CODIGO FROM GRUPO_PRODUTOS WHERE CODESTAB = ?');
        $qryGruposProd->execute([$cod_estab]);
        $grupos_codigos_gerados = $qryGruposProd->fetchAll(PDO::FETCH_ASSOC);

        // Array combinando o código do Grupo de Produtos que veio da requisição com
        // o código gerado na inserção dos dados.
        $data_cod_com_cod_gerado = array_combine($data_codigos_gp, $grupos_codigos_gerados);

        $prodContr = new ProdutoController();
        foreach ($data_prod as $produto) {
            $cod_grupo = $data_cod_com_cod_gerado[$produto['CODGRUPO']]['CODIGO'];

            $prodContr::create($produto['NOME'], $cod_estab, $cod_grupo);
        }

        unset($pdo);
        unset($grupoProdContr);
        unset($prodContr);
    }
}
