<?php
    require_once __DIR__ . '/cors.php';
    require_once __DIR__ . '/conexao.php';
    require_once __DIR__ . '/Middlewares/Token.php';
    require_once __DIR__ . '/Utils/index.php';
    
    $headers = apache_request_headers();
    
    if(!isset($headers['Authorization']) || $headers['Authorization'] == ""){
        require_once __DIR__ . '/Routes/RotasNaoAutenticadas/index.php';
    }else{
        $tokenCheck = Token::check($headers['Authorization']);

        if($tokenCheck){
            require_once __DIR__ . '/Routes/RotasAutenticadas/index.php';
        }else{
            http_response_code(401);
            echo json_encode([
                "message" => 'Token inválido'
            ]);
        }
    }
?>