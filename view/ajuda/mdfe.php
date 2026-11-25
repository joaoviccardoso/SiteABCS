<?php
require_once __DIR__ . '/ajuda.php';

ajuda_pagina([
    'nome'   => 'ABCS MDFe',
    'marca'  => 'MDFe',
    'classe' => 'mdfe',
    'extras' => [
        ['Como adquiro o ABCS MDFe?',
         "Basta entrar em contato com a ABCS e um de nós irá te retornar. Você pode fazer isso clicando
          <a class='text-primary' href='../contato/" . rawurlencode('Quero o ABCS MDFe') . "'>aqui</a>
          ou ligando no telefone <a class='text-primary' href='tel:+551938661100'>(19) 3866 1100</a>."],
    ],
]);