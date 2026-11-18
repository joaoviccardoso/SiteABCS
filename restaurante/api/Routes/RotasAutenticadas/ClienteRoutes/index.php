<?php
    if(isset($uri[3])){
        VerificaRequestMethod('POST');
        $data = json_decode(file_get_contents('php://input'), true);

        switch($uri[3]){
            case 'get':
                VerificaRequestData(['codigo'], $data);

                $clientesContr = new ClienteController();
                $clientesContr->getCliente($data['codigo']);
                break;        
            case 'create':
                VerificaRequestData(['nome', 'endereco', 'telefone'], $data);

                $clientesContr = new ClienteController();
                $clientesContr->create($data);
                break;        
            case 'update':
                VerificaRequestData(['codigo', 'nome', 'endereco', 'telefone'], $data);

                $clientesContr = new ClienteController();
                $clientesContr->update($data['codigo'], $data);
                break;        
            case 'delete':
                VerificaRequestData(['codigo'], $data);

                $clientesContr = new ClienteController();
                $clientesContr->delete($data['codigo']);
                break;
            default:
                http_response_code(404);
                echo json_encode([
                    "message" => "Não foi possível encontrar a URL solicitada."
                ]);
                break; 
        }
    }else{
        $clientesContr = new ClienteController();
        $clientesContr->getClientes();
        die();
    }
?>