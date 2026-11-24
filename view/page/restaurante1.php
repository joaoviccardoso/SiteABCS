<?php
// view/page/restaurante.php — Página do sistema ABCS RESTAURANTE (nav/footer vêm do layoutModel)
// Usa o mesmo CSS do Premium (css/premium.css, escopo .prm). Só mudam textos, logo e funcionalidades.
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o Restaurante em meu restaurante');

$logo_arquivo = 'img/sistemas/restaurante.png';
$tem_logo     = file_exists($raiz . '/' . $logo_arquivo);

$funcionalidades = [
    ['fa-th-large', 'Controle de mesas', 'Acompanhe a situação de cada mesa do seu salão.'],
    ['fa-list-alt', 'Lançamento de pedidos', 'Registre os pedidos de forma rápida e organizada.'],
    ['fa-shopping-basket', 'Controle de consumo', 'Acompanhe o consumo de cada mesa com facilidade.'],
    ['fa-file-text-o', 'Emissão de cupons fiscais', 'Emita cupons fiscais de forma rápida e organizada.'],
    ['fa-headphones', 'Suporte Remoto Especializado', 'Atendimento remoto com uma equipe especializada no sistema.'],
];
$grid_cls = (count($funcionalidades) === 4) ? ' prm-grid--2' : '';
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Sistema para Restaurantes</span>
                <h1>ABCS RESTAURANTE</h1>
                <p>O ABCS Restaurante é o sistema para a gestão do seu restaurante. Controle mesas, pedidos e consumo com facilidade, além de emitir cupons fiscais de forma rápida e organizada.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . '/' . $logo_arquivo ?>" alt="Logo ABCS RESTAURANTE">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-cutlery" aria-hidden="true"></i></span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FUNCIONALIDADES -->
    <section class="prm-func" id="funcionalidades">
        <div class="prm-container">
            <h2 class="prm-titulo">Funcionalidades e Benefícios</h2>
            <div class="prm-grid<?= $grid_cls ?>">
                <?php foreach ($funcionalidades as $f): ?>
                    <article class="prm-card">
                        <span class="prm-card__icone"><i class="fa <?= $f[0] ?>" aria-hidden="true"></i></span>
                        <h3><?= htmlspecialchars($f[1]) ?></h3>
                        <p><?= htmlspecialchars($f[2]) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="prm-cta">
        <div class="prm-container">
            <div class="prm-cta__box">
                <h2>Quer o ABCS Restaurante no seu restaurante?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS RESTAURANTE.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>