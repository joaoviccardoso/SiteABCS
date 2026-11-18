<?php
    if(isset($uri[3])){

        switch($uri[3]){
            case 'info':
                VerificaRequestMethod('GET');

                $dashboardContr = new DashboardController();
                $dashboardContr->getDashboardInfo();
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