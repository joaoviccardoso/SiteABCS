<?php
if (isset($uri[3])) {
    switch ($uri[3]) {
        case 'rotas':
            VerificaRequestMethod('GET');
            $estabsContr = new EstabelecimentoController();
            $estabsContr->getRotas();
            break;
        case 'get':
            if (isset($uri[4]) && isset($uri[5])) {
                if ($uri[5] == "usuario") {
                    VerificaRequestMethod('GET');

                    $estabsContr = new EstabelecimentoController();
                    $estabsContr->getEstabelecimentoMenuByUsuario($uri[4]);
                    break;
                }
            }
    }
}
