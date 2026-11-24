<?php
// view/page/sysin.php — Página do sistema ABCS SYSIN (nav/footer vêm do layoutModel)
// Usa o mesmo CSS do Premium (css/premium.css, escopo .prm). Só mudam textos, logo e funcionalidades.
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o SysIn em meu hotel');

$logo_arquivo = 'img/sistemas/sysin.png';
$tem_logo     = file_exists($raiz . '/' . $logo_arquivo);

$funcionalidades = [
    ['fa-eye', 'Fácil visualização das suítes alugadas', 'Veja rapidamente a situação de cada suíte.'],
    ['fa-calculator', 'Cálculo automático de estadia e consumo', 'O sistema calcula estadia e consumo para você.'],
    ['fa-files-o', 'Relatórios personalizados', 'Relatórios personalizados para o seu hotel.'],
    ['fa-money', 'Tabela de preço por dia e horário', 'Defina preços por dia e por horário de check-in.'],
    ['fa-file-text-o', 'Emissão de Nota Fiscal Paulista', 'Emita a Nota Fiscal Paulista pelo próprio sistema.'],
    ['fa-clock-o', 'Organização de turnos de trabalho', 'Organize os turnos da sua equipe.'],
    ['fa-headphones', 'Suporte Remoto Especializado', 'Atendimento remoto com uma equipe especializada no sistema.'],
];
$grid_cls = (count($funcionalidades) === 4) ? ' prm-grid--2' : '';
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Administração de Hotéis</span>
                <h1>ABCS SYSIN</h1>
                <p>O ABCS SysIn é o sistema completo para a gestão do seu hotel, simplificando o seu dia a dia como gestor.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . '/' . $logo_arquivo ?>" alt="Logo ABCS SYSIN">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-building-o" aria-hidden="true"></i></span>
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
                <h2>Quer o ABCS SYSIN em seu hotel?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS SYSIN.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>