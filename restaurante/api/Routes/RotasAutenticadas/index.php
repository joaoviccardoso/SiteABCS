<?php
    require_once __DIR__ . '/../../Controllers/ClienteController.php';
    require_once __DIR__ .  '/../../Controllers/EstabelecimentoController.php';
    require_once __DIR__ .  '/../../Controllers/CargaController.php';
    require_once __DIR__ .  '/../../Controllers/DashboardController.php';

    $uri = explode("/", $_SERVER['REQUEST_URI']);

    if(isset($uri[2])){
        if($uri[2] == 'clientes'){
            include 'ClienteRoutes/index.php';
        }elseif($uri[2] == 'estabelecimentos'){
            include 'EstabelecimentoRoutes/index.php';
        }elseif($uri[2] == 'carga'){
            include 'CargaRoutes/index.php';
        }elseif($uri[2] == 'dashboard'){
            include 'DashboardRoutes/index.php';
        }else{
            http_response_code(404);
            echo json_encode([
                "message" => "Não foi possível encontrar a URL solicitada."
            ]);
            die();
        }
    }else{
        http_response_code(404);
        echo json_encode([
            "message" => "Não foi possível encontrar a URL solicitada."
        ]);
        die();
    }
?>