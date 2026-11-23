<section class="servico" id="pagina4">
  <div class="servico__grid">
    <div class="servico__conteudo">
      <p class="servico__eyebrow">Soluções corporativas</p>
      <h1>Acesse sua senha do sistema ABCS</h1>
      <p class="servico__texto">Informe o número de série para gerar ou recuperar sua senha de acesso com segurança.</p>

      <form class="servico__form" method="POST" action="/senha">
        <label for="serial">Digite seu serial:</label>
        <input type="text" name="serial" id="serial" placeholder="Serial"
               style="text-transform: uppercase;"
               value="<?php echo htmlspecialchars($serial ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
        <button class="servico__btn" type="submit">Gerar Senha</button>
      </form>

      <?php if ($_POST) { ?>
        <div class="servico__resultado">
          <?php echo $this->retornoSite($obj); ?>
        </div>
      <?php } ?>
    </div>

    <div class="servico__foto">
      <img src="/img/GerarSenha.png" alt="Pessoa usando celular com cadeado de segurança diante de um notebook" />
    </div>
  </div>
</section>