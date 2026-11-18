<?php
class DashboardController {
    public function getDashboardInfo(){
        $pdo = new Conexao();

        $qryClientes = $pdo->query('SELECT count(*) FROM CLIENTES');
        $qryClientes->execute();
        $clientesFetch = $qryClientes->fetchColumn();
        
        $qryEstabelecimentos = $pdo->query('SELECT count(*) FROM ESTABELECIMENTOS');
        $qryEstabelecimentos->execute();
        $estabFetch = $qryEstabelecimentos->fetchColumn();

        $qryCargas = $pdo->query('SELECT count(*) FROM HISTORICO_CARGA');
        $qryCargas->execute();
        $cargasFetch = $qryCargas->fetchColumn();

        unset($pdo);

        $dashboardInfo = [
            "qtdClientes" => $clientesFetch,
            "qtdEstabelecimentos" => $estabFetch,
            "qtdCargas" => $cargasFetch
        ];

        http_response_code(200);
        echo json_encode([
            "data" => $dashboardInfo,
        ]);    
    }
}