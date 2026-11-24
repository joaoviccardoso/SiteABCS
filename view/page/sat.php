<?php
// view/page/sat.php — Página do sistema ABCS SAT (nav/footer vêm do layoutModel)
// Usa o mesmo CSS do Premium (css/premium.css, escopo .prm). Só mudam textos, logo e funcionalidades.
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o SAT em minha empresa');

$logo_arquivo = 'img/sistemas/nfce.png';
$tem_logo     = file_exists($raiz . '/' . $logo_arquivo);

$funcionalidades = [
    ['fa-file-text-o', 'Emitir Cupons Fiscais', 'Emita seus cupons fiscais com simplicidade e agilidade.'],
    ['fa-files-o', 'Gerenciar Cupons Fiscais emitidos', 'Acompanhe e gerencie todos os cupons já emitidos.'],
    ['fa-shopping-basket', 'Gerenciar os produtos que você vende', 'Mantenha o cadastro dos seus produtos organizado.'],
    ['fa-line-chart', 'Relatórios de produtos vendidos', 'Veja quais produtos mais saem na sua empresa.'],
    ['fa-users', 'Gerenciar seus clientes', 'Mantenha o cadastro dos seus clientes organizado.'],
    ['fa-headphones', 'Suporte Remoto Especializado', 'Atendimento remoto com uma equipe especializada no sistema.'],
];
$grid_cls = (count($funcionalidades) === 4) ? ' prm-grid--2' : '';
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Emissor de Cupom Fiscal</span>
                <h1>ABCS SAT</h1>
                <p>O ABCS SAT é o Sistema para emissão de Cupom Fiscal. Emita e gerencie seus cupons com simplicidade e agilidade.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . '/' . $logo_arquivo ?>" alt="Logo ABCS SAT">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-barcode" aria-hidden="true"></i></span>
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
                <h2>Quer o ABCS SAT em sua empresa?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS SAT.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>