<?php
    if(isset($uri[3])){

        switch($uri[3]){
            case 'receber':
                VerificaRequestMethod('POST');
                $data = json_decode(file_get_contents('php://input'), true);
                VerificaRequestData(['grupos_prod', 'produtos'], $data);

                $cargaContr = new CargaController();
                $cargaContr->receberCarga($data);
                break; 
            case 'historico':
                VerificaRequestMethod('GET');

                $cargaContr = new CargaController();
                $cargaContr->getHistoricoCarga();
                break; 
            default:
                http_response_code(404);
                echo json_encode([
                    "message" => "Não foi possível encontrar a URL solicitada."
                ]);
                break; 
        }
    }
?>