<?php
// view/page/manutencao.php — conteúdo da página (nav/footer vêm do layoutModel)
$dot = isset($dot) ? $dot : '';

$whatsapp = '5519999999999'; // TROCAR: DDI + DDD + número
$link_atendimento = 'https://wa.me/' . $whatsapp . '?text=' . rawurlencode('Olá! Gostaria de solicitar atendimento de manutenção.');

$servicos = [
    [
        'icone'  => 'fa-desktop',
        'titulo' => 'Manutenção de Computadores (Preventiva e Corretiva)',
        'texto'  => 'Cuidamos do seu computador com rotinas para evitar problemas e reparos rápidos quando necessário, garantindo mais desempenho e maior vida útil.',
    ],
    [
        'icone'  => 'fa-print',
        'titulo' => 'Manutenção de Impressoras (Preventiva e Corretiva)',
        'texto'  => 'Realizamos revisão para evitar paradas inesperadas, com limpeza, ajustes e troca de peças. Conserto rápido, qualidade e menos custo.',
    ],
    [
        'icone'  => 'fa-microchip',
        'titulo' => 'Upgrade de Componentes',
        'texto'  => 'Instalação de SSD, memória RAM e outras peças para deixar seus equipamentos mais rápidos e com melhor desempenho.',
    ],
];
?>

<main class="mnt">

    <!-- HERO -->
    <section class="mnt-hero" style="background-image:linear-gradient(180deg,rgba(11,23,48,.82),rgba(11,23,48,.92)),url('<?= $dot ?>/img/data-center.jpg')">
        <div class="mnt-container">
            <h1>Manutenção de Equipamentos para sua Empresa</h1>
            <p>Cuidamos dos seus computadores e impressoras para evitar problemas e manter tudo funcionando corretamente. Oferecemos suporte rápido e eficiente para que sua empresa não pare e continue produtiva no dia a dia.</p>
            <a class="mnt-btn" href="<?= htmlspecialchars($link_atendimento) ?>" target="_blank" rel="noopener">Solicitar atendimento</a>
        </div>
    </section>

    <!-- SERVIÇOS -->
    <section class="mnt-servicos">
        <div class="mnt-container mnt-grid">
            <div class="mnt-servicos__texto">
                <span class="mnt-badge"><i class="fa fa-wrench"></i> Serviço técnico</span>
                <h2>Manutenção de Computadores</h2>
                <p class="mnt-lead">Diagnóstico e atendimento rápido do seu hardware, com diagnóstico preciso e intervenções técnicas de alto nível.</p>

                <ul class="mnt-cards">
                    <?php foreach ($servicos as $s): ?>
                        <li class="mnt-card">
                            <i class="fa <?= $s['icone'] ?>" aria-hidden="true"></i>
                            <div>
                                <h3><?= htmlspecialchars($s['titulo']) ?></h3>
                                <p><?= htmlspecialchars($s['texto']) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="mnt-servicos__img">
                <img src="<?= $dot ?>/img/manutencao-placa.jpg" alt="Técnico realizando manutenção em placa de computador" loading="lazy">
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="mnt-cta">
        <div class="mnt-container">
            <h2>Pronto para elevar sua tecnologia?</h2>
            <p>Não deixe sua empresa parar por falhas técnicas. Tenha ao seu lado a parceria de TI que entende do seu negócio.</p>
            <a class="mnt-btn" href="<?= htmlspecialchars($link_atendimento) ?>" target="_blank" rel="noopener">Solicitar atendimento</a>
        </div>
    </section>

</main>