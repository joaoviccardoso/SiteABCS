<?php
// view/page/mdfe.php — Página do sistema ABCS MDFe (nav/footer vêm do layoutModel)
// Usa o mesmo CSS do Premium (css/premium.css, escopo .prm). Só mudam textos, logo e funcionalidades.
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o MDFe em minha empresa');

$logo_arquivo = 'img/sistemas/mdfe.png';
$tem_logo     = file_exists($raiz . '/' . $logo_arquivo);

$funcionalidades = [
    ['fa-file-text-o', 'Emitir Manifestos de Documento Fiscal', 'Emita seus manifestos com simplicidade e agilidade.'],
    ['fa-files-o', 'Gerenciar Manifestos emitidos', 'Acompanhe e gerencie todos os manifestos já emitidos.'],
    ['fa-users', 'Gerenciar seus clientes', 'Mantenha o cadastro dos seus clientes organizado.'],
    ['fa-truck', 'Gerenciar caminhões e motoristas', 'Cadastre e organize a sua frota e os seus motoristas.'],
    ['fa-headphones', 'Suporte Remoto Especializado', 'Atendimento remoto com uma equipe especializada no sistema.'],
];
$grid_cls = (count($funcionalidades) === 4) ? ' prm-grid--2' : '';
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Emissão de Manifesto de Documento Fiscal</span>
                <h1>ABCS MDFe</h1>
                <p>O ABCS MDFe é o Sistema para emissão de Manifesto de Documento Fiscal. Emita e gerencie seus manifestos com simplicidade e agilidade.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . '/' . $logo_arquivo ?>" alt="Logo ABCS MDFe">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-list-alt" aria-hidden="true"></i></span>
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
                <h2>Quer o ABCS MDFe em sua empresa?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS MDFe.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>