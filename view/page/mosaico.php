<?php
// view/page/citrus.php
$dot = isset($dot) ? $dot : '';

// Caminho da imagem relativo à raiz pública do site (pasta onde fica "img/")
$logo_rel = '/img/LogoMosaicoGrande.png';

// Raiz no disco. Ajuste conforme a estrutura do projeto (veja as opções abaixo)
$raiz = dirname(__DIR__, 2);

// Caminho físico do arquivo e verificação
$logo_arquivo = $raiz . $logo_rel;
$tem_logo     = file_exists($logo_arquivo);

$link_demo = $dot . '/contato/' . rawurlencode('Quero o Mosaico em meu motel');

$funcionalidades = [
    ['fa-eye', 'Fácil visualização das suítes alugadas', 'Veja rapidamente a situação de cada suíte.'],
    ['fa-calculator', 'Cálculo automático de estadia e consumo', 'O sistema calcula estadia e consumo para você.'],
    ['fa-files-o', 'Relatórios personalizados', 'Relatórios personalizados para o seu motel.'],
    ['fa-money', 'Tabela de preço por dia e horário', 'Defina preços por dia e por horário de check-in.'],
    ['fa-file-text-o', 'Emissão de Nota Fiscal Paulista', 'Emita a Nota Fiscal Paulista pelo próprio sistema.'],
    ['fa-clock-o', 'Organização de turnos de trabalho', 'Organize os turnos da sua equipe.'],
    ['fa-plug', 'Corte de energia em suítes vazias', 'Desligue a energia das suítes desocupadas.'],
    ['fa-unlock-alt', 'Abertura automática de portões', 'Automatize a abertura dos portões.'],
    ['fa-headphones', 'Suporte Remoto Especializado', 'Atendimento remoto com uma equipe especializada no sistema.'],
];
$grid_cls = (count($funcionalidades) === 4) ? ' prm-grid--2' : '';
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Segurança e Gestão para Motéis</span>
                <h1>ABCS MOSAICO</h1>
                <p>O ABCS Mosaico é o sistema completo para a gestão do seu motel, simplificando o seu dia a dia como gestor.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                </div>
            </div>
            <div class="prm-hero__logo">
                <?php if ($tem_logo): ?>
                    <img src="<?= $dot . $logo_rel ?>" alt="Logo ABCS Mosaico">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-bed" aria-hidden="true"></i></span>
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
                <h2>Quer o ABCS MOSAICO em seu motel?</h2>
                <p>Fale com a nossa equipe e solicite uma demonstração do ABCS MOSAICO.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>