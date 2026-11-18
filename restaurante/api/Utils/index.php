<?php
    function VerificaRequestMethod($method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            // 405 Method Not Allowed - Resposta HTTP para requisições feitas usando
            // método que não era esperado pela API.
            error_log('Erro 405 - Requisição com método inválido.', 0);
            http_response_code(405);
            echo json_encode([
                "message" => "Requisição com método não permitido.
                        Era esperado o uso do método '" . $method . "'
                        e foi usado '" . $_SERVER['REQUEST_METHOD'] . "'.",
            ]);
            die();
        }
    }

    function VerificaRequestData($keys, $data)
    {
        foreach ($keys as $key) {
            if (empty($data)) {
                // 400 Bad Request - Resposta HTTP para requisições com dados faltando.
                error_log('Error 400 - Requisição com dados vazios.', 0);
                http_response_code(405);
                echo json_encode([
                    "message" => "Não foi enviado dados na requisição.",
                ]);
                die();
            }

            if (!isset($data[$key])) {
                error_log('Error 405 - Requisição com dados faltando. Era esperado o item ' . $key, 0);
                http_response_code(405);
                echo json_encode([
                    "message" => "Era esperado o item '" . $key . "' na requisição.",
                ]);
                die();
            }
        }
    }

    // Função geradora de token UUID
    function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
?>
