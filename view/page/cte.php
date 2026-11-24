<?php
// view/page/cte.php — Página do sistema ABCS CTe (nav/footer vêm do layoutModel)
// Usa o mesmo CSS do Premium (css/premium.css, escopo .prm). Só mudam textos, logo e funcionalidades.
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o CTe em minha empresa');

$logo_arquivo = 'img/sistemas/cte.png';
$tem_logo     = file_exists($raiz . '/' . $logo_arquivo);

$funcionalidades = [
    ['fa-file-text-o', 'Emitir Conhecimentos de Transportes', 'Emita seus conhecimentos de transporte com simplicidade e agilidade.'],
    ['fa-files-o', 'Gerenciar Conhecimentos emitidos', 'Acompanhe e gerencie todos os conhecimentos já emitidos.'],
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
                <span class="prm-badge">Emissão de Conhecimento de Transportes</span>
                <h1>ABCS CTe</h1>
                <p>O ABCS CTe é o Sistema para emissão de Conhecimento de Transportes. Emita e gerencie seus conhecimentos de transporte com simplicidade e agilidade.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . '/' . $logo_arquivo ?>" alt="Logo ABCS CTe">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-truck" aria-hidden="true"></i></span>
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
                <h2>Quer o ABCS CTe em sua empresa?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS CTe.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>