<?php
require_once __DIR__ . '/ajuda.php';
ajuda_assets();

$sistemas = [
    ['premium', 'Premium', 'premium'],
    ['mosaico', 'Mosaico', 'mosaico'],
    ['citrus',  'Citrus',  'citrus'],
    ['nfe',     'NFe',     'nfe'],
    ['sysin',   'SysIn',   'sysin'],
    ['sat',     'SAT',     'sat'],
    ['cte',     'CTe',     'cte'],
    ['mdfe',    'MDFe',    'mdfe'],
];
?>
<div class='container text-center' id='pagina'>
  <h1>Ajuda com seu sistema <span class='brand'>ABCS</span></h1>
  <h3>Encontre ajuda para as dificuldades que você pode enfrentar</h3>

  <div class='ajuda-grid'>
    <?php foreach ($sistemas as [$slug, $label, $classe]): ?>
    <a class='ajuda-card' href='./ajuda/<?= $slug ?>'>
      <h2><?= ajuda_marca($label, $classe) ?></h2>
    </a>
    <?php endforeach; ?>
  </div>
</div>