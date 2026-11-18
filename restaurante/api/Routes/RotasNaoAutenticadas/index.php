<?php
    require_once __DIR__ .  '/../../Controllers/LoginController.php';
    require_once __DIR__ . '/../../Controllers/ClienteController.php';
    require_once __DIR__ .  '/../../Controllers/EstabelecimentoController.php';

    $uri = explode("/", $_SERVER['REQUEST_URI']);

    if(isset($uri[2])){
        if($uri[2] == 'login'){
            include 'LoginRoutes/index.php';
        }elseif($uri[2] == 'estabelecimentos'){
            include 'EstabelecimentoRoutes/index.php';
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