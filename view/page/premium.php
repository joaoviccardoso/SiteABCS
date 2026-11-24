<?php
// view/page/premium.php — Página do sistema ABCS Premium (nav/footer vêm do layoutModel)
$logo_rel     = '/img/LogoPremiumGrande.png';   // ajuste para o caminho real
$dot  = isset($dot) ? $dot : '';
$raiz = dirname(__DIR__, 2);
$logo_premium = file_exists($raiz . $logo_rel);
// Mesmo padrão das outras páginas: a mensagem vai na URL de /contato
$link_demo   = $dot . '/contato/' . rawurlencode('Quero uma demonstração do ABCS Premium');
$link_planos = $dot . '/contato/' . rawurlencode('Quero conhecer os planos do ABCS Premium');

$empresas = '+800'; // CONFERIR o número. Deixe '' para esconder a linha de prova social.

$funcionalidades = [
    ['fa-archive',       'Controle de estoque',          'Gestão precisa de entradas e saídas, com atualização automática de reposição e histórico completo.'],
    ['fa-shopping-cart', 'Gestão de Compras e Vendas',   'Fluxo otimizado, do pedido de compra ao PDV final, garantindo agilidade no atendimento.'],
    ['fa-bar-chart',     '+70 Modelos de Relatórios',    'Dados estratégicos em tempo real para decisões baseadas nos números do seu negócio.'],
    ['fa-university',    'Gestão Financeira',            'Contas a pagar e receber, fluxo de caixa, conciliação bancária e integração fiscal.'],
    ['fa-file-text-o',   'Emissão de NF-e',              'Processo simplificado para emitir notas fiscais eletrônicas e cupons fiscais com rapidez.'],
    ['fa-wrench',        'Ordens de Serviço',            'Controle total da prestação de serviços: prazos, técnicos e materiais utilizados.'],
    ['fa-envelope-o',    'Envio Automático de XML/PDF',  'Automação do envio de documentos fiscais para clientes e contabilidade, sem esforço manual.'],
    ['fa-puzzle-piece',  'Módulos Personalizados',       'Flexibilidade para adaptar o sistema conforme as necessidades específicas do seu negócio.'],
    ['fa-headphones',    'Suporte Especializado',        'Atendimento humanizado e técnico para garantir que sua empresa nunca pare de crescer.'],
];
?>
<main class="prm">

    <!-- HERO -->
    <section class="prm-hero">
        <div class="prm-container prm-hero__grid">
            <div class="prm-hero__texto">
                <span class="prm-badge">Gerenciador comercial</span>
                <h1>ABCS PREMIUM</h1>
                <p>O ABCS PREMIUM é o gerenciador comercial ideal para pequenas e médias empresas que buscam excelência operacional. Uma plataforma robusta, intuitiva e completa para transformar a gestão do seu negócio.</p>
                <div class="prm-hero__acoes">
                    <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
                    <a class="prm-btn prm-btn--contorno" href="<?= htmlspecialchars($link_planos) ?>">Ver planos</a>
                </div>
                <?php if ($empresas !== ''): ?>
                    <p class="prm-prova"><i class="fa fa-check-circle" aria-hidden="true"></i> <strong><?= htmlspecialchars($empresas) ?> empresas</strong> confiam no ABCS</p>
                <?php endif; ?>
            </div>
            <div class="prm-hero__logo">
                <?php if ($logo_premium): ?>
                    <img src="<?= $dot . $logo_rel ?>" alt="Logo ABCS Premium">
                <?php else: ?>
                    <span class="prm-hero__icone"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FUNCIONALIDADES -->
    <section class="prm-func" id="funcionalidades">
        <div class="prm-container">
            <h2 class="prm-titulo">Funcionalidades e Benefícios</h2>
            <div class="prm-grid">
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
                <h2>Pronto para elevar o nível da sua gestão?</h2>
                <p>Junte-se a centenas de empresas que já transformaram seus processos com o ABCS PREMIUM. Nossa equipe está pronta para te ajudar.</p>
                <a class="prm-btn" href="<?= htmlspecialchars($link_demo) ?>">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>