<?php
/**
 * Helper compartilhado das páginas de ajuda ABCS.
 * Ajuste AJUDA_ASSETS se os arquivos CSS/JS ficarem em outro caminho.
 */
// Descobre sozinho a URL da pasta (ex.: /ABCS/view/ajuda) para achar ajuda.css e ajuda.js
if (!defined('AJUDA_ASSETS')) {
    $raiz = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $pasta = str_replace('\\', '/', __DIR__);
    define('AJUDA_ASSETS', substr($pasta, strlen($raiz)));
}

function ajuda_h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

/** Marca ABCS + produto (usa as classes .brand / .subbrand já existentes no site) */
function ajuda_marca($label, $classe) {
    return "<span class='brand black'>ABCS</span> <span class='subbrand " . ajuda_h($classe) . "'>" . ajuda_h($label) . "</span>";
}

/**
 * Imprime o CSS (arquivo) e o JS (inline, igual ao original) uma única vez.
 * O JS fica inline para funcionar mesmo quando a página é carregada via AJAX.
 */
function ajuda_assets() {
    static $feito = false;
    if ($feito) return;
    $feito = true;
    echo "<link rel='stylesheet' href='" . AJUDA_ASSETS . "/ajuda.css'>\n";
    ?>
<script>
    if (!window.ajudaAccordion) {
        window.ajudaAccordion = true;
        document.addEventListener("click", function (e) {
            var botao = e.target.closest(".accordion");
            if (!botao) return;
            botao.classList.toggle("active");
            var painel = botao.nextElementSibling;
            painel.style.maxHeight = painel.style.maxHeight ? null : painel.scrollHeight + "px";
        });
    }
</script>
<?php
}

/**
 * Renderiza uma página de ajuda.
 *  nome    : como o produto é citado no texto   (ex.: "ABCS NFe")
 *  marca   : texto do selo no título            (ex.: "NFe")
 *  classe  : classe de cor do subbrand          (ex.: "nfe")
 *  extras  : perguntas específicas do produto   [[pergunta, resposta_html], ...]
 */
function ajuda_pagina(array $p) {
    $nome    = $p['nome'];
    $assunto = 'Dúvidas com o ' . ($p['assunto'] ?? ('ABCS ' . $p['marca']));
    $faqs    = $p['extras'] ?? [];

    $faqs[] = [
        "Meu {$nome} está me pedindo uma senha, como eu consigo ela?",
        "A senha no {$nome} é uma forma de garantir sua autenticidade e sua segurança. Você pode obter a senha clicando
         <a class='text-primary' href='./../senha'>aqui</a> e digitando o número de série de seu sistema,
         que estará na tela que pede sua senha.",
    ];
    $faqs[] = [
        "Não recebi meu boleto, como eu faço para emiti-lo?",
        "O seu boleto sempre estará disponível on-line. Você pode emitir seu boleto clicando
         <a class='text-primary' href='./../boleto'>aqui</a> e digitando o seu CPF ou CNPJ.",
    ];

    ajuda_assets();
    ?>
<div class='container' id='pagina'>
    <h1><?= ajuda_marca($p['marca'], $p['classe']) ?></h1>

    <?php foreach ($faqs as $i => $faq): $id = 'faq-' . $p['classe'] . '-' . $i; ?>
    <button class="accordion" type="button" aria-expanded="false" aria-controls="<?= $id ?>">
        <?= ajuda_h($faq[0]) ?>
    </button>
    <div class="panel" id="<?= $id ?>">
        <?php foreach ((array) $faq[1] as $par): ?>
        <p><?= $par ?></p>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <div class='ajuda-rodape'>
        <a class='btn btn-primary' href='../contato/<?= rawurlencode($assunto) ?>'>Não achei minha dúvida</a>
    </div>
</div>
<?php
}