<?php
// view/page/sistemas.php — Página "Sistemas" (nav/footer vêm do layoutModel)
$dot = isset($dot) ? $dot : '';

$whatsapp = '551938661100';
$link_contato = 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode('Olá! Gostaria de conhecer os sistemas da ABCS Informática.');

// Pasta física da raiz do projeto (onde fica a pasta /img).
// Se as imagens não forem encontradas, confira este valor (veja o comentário de debug mais abaixo).
$raiz     = dirname(__DIR__, 2);
$pastaImg = '/img'; // todas as imagens ficam em <raiz>/img/

// Cada card tem 'span' (largura em 12 colunas), 'logo' (img/<logo>.png) e opcionalmente 'foto' (img/<foto>).
// Se o arquivo da logo não existir, usa o ícone Font Awesome. 'link' substitui a rota (ex.: página ainda sem rota).
$sistemas = [
    ['span' => 7, 'rota' => 'premium', 'logo' => 'LogoPremium', 'icone' => 'fa-shopping-cart', 'destaque' => false,
     'titulo' => 'ABCS Premium - Gerenciador Comercial',
     'texto'  => 'Uma solução centralizada para o controle absoluto do seu negócio. Gerencie finanças, monitore o estoque em tempo real e gere relatórios estratégicos para tomada de decisão.'],
    ['span' => 5, 'rota' => 'nfe', 'logo' => 'LogoNFe', 'icone' => 'fa-file-text-o', 'destaque' => true,
     'titulo' => 'ABCS NF-e - Emissor de NF-e',
     'texto'  => 'Emita notas fiscais eletrônicas de forma rápida e segura. Cadastro simplificado de clientes e produtos integrado ao sistema fiscal.'],

    ['span' => 4, 'rota' => 'sat', 'logo' => 'LogoNFCe', 'icone' => 'fa-barcode', 'destaque' => false,
     'titulo' => 'ABCS NFC-e – Emissor de Nota Fiscal ao Consumidor',
     'texto'  => 'Realize vendas com mais agilidade e gere notas fiscais automaticamente, garantindo praticidade no atendimento.'],
    // >>> Troque 'citrus-campo.jpg' pelo nome EXATO da foto nova (dentro de /img), incluindo maiúsculas e extensão.
    ['span' => 8, 'rota' => 'citrus', 'logo' => 'LogoCiturs', 'icone' => 'fa-leaf', 'destaque' => false, 'foto' => 'citrus-campo.png',
     'titulo' => 'ABCS Citrus – Sistema para Administração de Fazendas',
     'texto'  => 'Tenha controle da produção, custos e atividades rurais, facilitando a gestão da sua fazenda no dia a dia.'],

    ['span' => 5, 'rota' => 'mosaico', 'logo' => 'LogoMosaico', 'icone' => 'fa-bed', 'destaque' => true,
     'titulo' => 'ABCS Mosaico – Automação para Motéis',
     'texto'  => 'Gerencie reservas, consumo e operações do seu motel com mais organização, agilidade e controle total.'],
    ['span' => 7, 'rota' => 'restaurante1', 'logo' => 'LogoRestaurante', 'icone' => 'fa-cutlery', 'destaque' => false,
     'titulo' => 'ABCS Restaurante – Sistema para Restaurantes',
     'texto'  => 'Controle mesas, pedidos e consumo com facilidade, além de emitir cupons fiscais de forma rápida e organizada.'],

    ['span' => 4, 'rota' => 'sysin', 'logo' => 'sysin', 'icone' => 'fa-building-o', 'destaque' => false,
     'titulo' => 'ABCS SysIn – Segurança e Gestão para Hotéis',
     'texto'  => 'Solução de segurança e gestão pensada para a rotina da hotelaria.'],
    ['span' => 4, 'rota' => 'cte', 'logo' => 'cte', 'icone' => 'fa-truck', 'destaque' => false,
     'titulo' => 'ABCS CT-e – Conhecimento de Transporte',
     'texto'  => 'Emissão e gerenciamento de Conhecimento de Transporte Eletrônico para transportadoras.'],
    ['span' => 4, 'rota' => 'mdfe', 'logo' => 'mdfe', 'icone' => 'fa-list-alt', 'destaque' => false,
     'titulo' => 'ABCS MDF-e – Manifesto de Transporte',
     'texto'  => 'Emissão e gerenciamento de Manifesto Eletrônico de Documentos Fiscais.'],
];
?>
<main class="sis">

    <!-- HERO -->
    <section class="sis-hero">
        <div class="sis-container sis-hero__grid">
            <div class="sis-hero__texto" data-aos="fade-up-right">
                <span class="sis-badge">Soluções corporativas</span>
                <h1>Sistemas que facilitam a gestão do seu negócio</h1>
                <p>Conheça as soluções completas da ABCS para gestão comercial, emissão fiscal, transporte, hotelaria e agronegócio.</p>
                <a class="sis-btn" href="<?= htmlspecialchars($link_contato) ?>" target="_blank" rel="noopener">Fale conosco</a>
            </div>
            <div class="sis-hero__img" data-aos="fade-up-left">
                <img src="<?= $dot . $pastaImg ?>/DashboarddeGestao.png" alt="Notebook exibindo um sistema de gestão">
            </div>
        </div>
    </section>

    <!-- CARDS -->
    <section class="sis-lista" id="solucoes">
        <div class="sis-container">
            <h2 class="sis-titulo">Nossas Soluções Digitais</h2>
            <div class="sis-cards" data-aos="zoom-in-up">
                <?php foreach ($sistemas as $s):
                    $externo = isset($s['link']);
                    $href    = $externo ? $s['link'] : $dot . '/' . $s['rota'];

                    // Caminhos relativos à raiz do projeto (usados na verificação E na exibição)
                    $logoRel = $pastaImg . '/' . $s['logo'] . '.png';
                    $temLogo = file_exists($raiz . $logoRel);

                    $fotoRel = isset($s['foto']) ? $pastaImg . '/' . $s['foto'] : null;
                    $temFoto = $fotoRel && file_exists($raiz . $fotoRel);

                    $classes = 'sis-card sis-span-' . $s['span']
                             . ($s['destaque'] ? ' sis-card--escuro' : '')
                             . ($temFoto ? ' sis-card--foto' : '');
                ?>
                    <?php /* DEBUG (remova depois): mostra onde o PHP procura a foto
                    if ($fotoRel) { echo '<!-- ' . $raiz . $fotoRel . ' existe? ' . ($temFoto ? 'SIM' : 'NAO') . ' -->'; }
                    */ ?>
                    <a class="<?= $classes ?>" href="<?= htmlspecialchars($href) ?>"<?= $externo ? ' target="_blank" rel="noopener"' : '' ?>>
                        <div class="sis-card__corpo">
                            <span class="sis-card__logo<?= $temLogo ? '' : ' sis-card__logo--icone' ?>">
                                <?php if ($temLogo): ?>
                                    <img src="<?= $dot . $logoRel ?>" alt="" loading="lazy">
                                <?php else: ?>
                                    <i class="fa <?= $s['icone'] ?>" aria-hidden="true"></i>
                                <?php endif; ?>
                            </span>
                            <h3><?= htmlspecialchars($s['titulo']) ?></h3>
                            <p><?= htmlspecialchars($s['texto']) ?></p>
                            <span class="sis-card__link">Saiba mais <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                        <?php if ($temFoto): ?>
                            <img class="sis-card__foto" src="<?= $dot . $fotoRel ?>" alt="" loading="lazy">
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="sis-cta">
        <div class="sis-container" data-aos="zoom-in-up">
            <div class="sis-cta__box">
                <h2>Pronto para transformar sua gestão?</h2>
                <p>Fale com a nossa equipe e descubra qual sistema é o ideal para o seu negócio.</p>
                <a class="sis-btn" href="<?= htmlspecialchars($link_contato) ?>" target="_blank" rel="noopener">Solicitar demonstração</a>
            </div>
        </div>
    </section>

</main>