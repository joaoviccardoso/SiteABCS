<?php
require_once __DIR__ . '/ajuda.php';

ajuda_pagina([
    'nome'   => 'ABCS CTe',
    'marca'  => 'CTe',
    'classe' => 'cte',
    'extras' => [
        ['O que é um CTe?', [
            'O Conhecimento de Transporte Eletrônico (CTe) é um documento eletrônico que acompanha a prestação de serviços
             de transporte. Um CTe é emitido eletronicamente, tal qual uma NFe.',
            'O principal objetivo do CTe é documentar, para fins fiscais, uma prestação de serviço de transporte de cargas
             realizada por qualquer modal (Rodoviário, Aéreo, Ferroviário, Aquaviário e Dutoviário).',
        ]],
        ['Como adquiro o ABCS CTe?',
         "Basta entrar em contato com a ABCS e um de nós irá te retornar. Você pode fazer isso clicando
          <a class='text-primary' href='../contato/" . rawurlencode('Quero o ABCS CTe') . "'>aqui</a>
          ou ligando no telefone <a class='text-primary' href='tel:+551938661100'>(19) 3866 1100</a>."],
    ],
]);