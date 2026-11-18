<?php
if (isset($uri[3])) {

    switch ($uri[3]) {
        case 'get':
            if (isset($uri[4]) && isset($uri[5])) {
                if ($uri[5] == "usuario") {
                    VerificaRequestMethod('GET');

                    $estabsContr = new EstabelecimentoController();
                    $estabsContr->getEstabelecimentoMenuByUsuario($uri[4]);
                    break;    
                }
            } else {
                VerificaRequestMethod('POST');
                $data = json_decode(file_get_contents('php://input'), true);
                VerificaRequestData(['codigo'], $data);
    
                $estabsContr = new EstabelecimentoController();
                $estabsContr->getEstabelecimento($data['codigo']);
                break;
            }
        case 'rotas':
            VerificaRequestMethod('GET');
            $estabsContr = new EstabelecimentoController();
            $estabsContr->getRotas();
            break;
        case 'create':
            VerificaRequestMethod('POST');
            $data = json_decode(file_get_contents('php://input'), true);
            VerificaRequestData(['nome', 'usuario','token'], $data);

            $estabsContr = new EstabelecimentoController();
            $estabsContr->create($data);
            break;
        case 'update':
            VerificaRequestMethod('POST');
            $data = json_decode(file_get_contents('php://input'), true);
            VerificaRequestData(['codigo', 'nome', 'token'], $data);

            $estabsContr = new EstabelecimentoController();
            $estabsContr->update($data['codigo'], $data);
            break;
        case 'delete':
            VerificaRequestMethod('POST');
            $data = json_decode(file_get_contents('php://input'), true);
            VerificaRequestData(['codigo'], $data);

            $estabsContr = new EstabelecimentoController();
            $estabsContr->delete($data['codigo']);
            break;
        default:
            http_response_code(404);
            echo json_encode([
                "message" => "Não foi possível encontrar a URL solicitada.",
            ]);
            break;
    }
} else {
    $estabsContr = new EstabelecimentoController();
    $estabsContr->getEstabelecimentos();
    die();
}
