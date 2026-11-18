<?php
    VerificaRequestMethod('POST');
    $data = json_decode(file_get_contents('php://input'), true);
    VerificaRequestData(['usuario', 'senha'], $data);

    $loginContr = new LoginController();
    $loginContr->login($data['usuario'], $data['senha']);
?>