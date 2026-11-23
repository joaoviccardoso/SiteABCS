<?php /* View de Contato — ABCS Informática. Navbar e footer continuam no layout do projeto. */ ?>
<link rel="stylesheet" href="/css/contato.css">

<section class="abcs-hero" aria-labelledby="abcs-hero-title">
  <div class="abcs-wrap-hero">
    <h1 id="abcs-hero-title">Entre em contato</h1>
    <p>Soluções inteligentes em TI para elevar o patamar tecnológico da sua empresa. Estamos prontos para atender suas demandas com precisão técnica.</p>
  </div>
</section>

<main class="abcs-wrap abcs-grid" id="pagina5">
  <div class="abcs-col">
    <section class="abcs-card abcs-info" aria-labelledby="abcs-info-title">
      <h2 id="abcs-info-title">Informações de Contato</h2>
      <ul>
        <!-- TROCAR o número do WhatsApp (DDI+DDD+número, só dígitos) -->
        <li>
          <span class="abcs-ico" aria-hidden="true"><i class="fa fa-whatsapp"></i></span>
          <span><small>WhatsApp</small>
            <a href="https://wa.me/5519999990000" target="_blank" rel="noopener">(19) 99999-0000</a></span>
        </li>
        <li>
          <span class="abcs-ico" aria-hidden="true"><i class="fa fa-phone"></i></span>
          <span><small>Telefone</small>
            <a href="tel:+551938661100">(19) 3866-1100</a></span>
        </li>
        <li>
          <span class="abcs-ico" aria-hidden="true"><i class="fa fa-envelope"></i></span>
          <span><small>E-mail</small>
            <a href="mailto:contato@abcsinformatica.com.br">contato@abcsinformatica.com.br</a></span>
        </li>
      </ul>
    </section>

    <div class="abcs-visual">
      <iframe
        title="Localização da ABCS Informática no Google Maps"
        src="https://www.google.com/maps?q=R.+das+Ang%C3%A9licas,+622+-+Centro,+Conchal+-+SP&amp;output=embed"
        loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <a class="abcs-loc" target="_blank" rel="noopener"
         href="https://www.google.com/maps/search/?api=1&amp;query=R.+das+Ang%C3%A9licas,+622+-+Centro,+Conchal+-+SP">
        <small><i class="fa fa-map-marker" aria-hidden="true"></i> Localização</small>
        <strong>R. das Angélicas, 622 - Centro</strong>
        <span>Conchal - SP</span>
      </a>
    </div>
  </div>

  <section class="abcs-card abcs-form-card" aria-labelledby="abcs-form-title">
    <h2 id="abcs-form-title">Envie uma mensagem</h2>
    <p class="abcs-sub">Preencha os campos abaixo e nossa equipe técnica retornará em até 24 horas úteis.</p>

    <!-- Integração original preservada: POST em ./contatoRealizado, mesmos names -->
    <form action="./contatoRealizado" method="post" id="contact_form" novalidate>
      <div class="abcs-row">
        <div class="abcs-field">
          <label for="nome">Nome Completo</label>
          <input id="nome" name="nome" type="text" placeholder="Seu nome" autocomplete="name" required>
          <span class="abcs-err" data-for="nome"></span>
        </div>
        <div class="abcs-field">
          <label for="email">E-mail Corporativo</label>
          <input id="email" name="email" type="email" placeholder="nome@empresa.com.br" autocomplete="email" required>
          <span class="abcs-err" data-for="email"></span>
        </div>
      </div>

      <div class="abcs-field">
        <label for="assunto">Assunto</label>
        <select id="assunto" name="assunto" required>
          <option>Consultoria em TI</option>
          <option>Suporte Técnico</option>
          <option>Infraestrutura</option>
          <option>Sistemas</option>
          <option>Outros</option>
        </select>
      </div>

      <div class="abcs-field">
        <label for="mensagem">Mensagem</label>
        <textarea id="mensagem" name="mensagem" rows="6" placeholder="Como podemos ajudar o seu negócio hoje?" required></textarea>
        <span class="abcs-err" data-for="mensagem"></span>
      </div>

      <p class="abcs-status" id="abcs-status" role="status" aria-live="polite"></p>

      <button type="submit" class="abcs-btn" id="abcs-submit">
        <i class="fa fa-paper-plane" aria-hidden="true"></i>
        <span>Enviar Mensagem Técnica</span>
      </button>
    </form>
  </section>
</main>

<script>
/* Validação do formulário de contato. O envio continua sendo o POST nativo para ./contatoRealizado. */
(function () {
  var form = document.getElementById('contact_form');
  if (!form) return;

  var btn = document.getElementById('abcs-submit');
  var status = document.getElementById('abcs-status');
  var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  var sending = false;

  function setError(input, msg) {
    var slot = form.querySelector('.abcs-err[data-for="' + input.name + '"]');
    input.classList.toggle('is-invalid', !!msg);
    input.setAttribute('aria-invalid', msg ? 'true' : 'false');
    if (slot) slot.textContent = msg || '';
  }

  function check(input) {
    var v = input.value.trim();
    var msg = '';
    if (!v) msg = 'Campo obrigatório.';
    else if (input.name === 'email' && !emailRe.test(v)) msg = 'Informe um e-mail válido.';
    else if (input.name === 'nome' && v.length < 3) msg = 'Informe seu nome completo.';
    else if (input.name === 'mensagem' && v.length < 10) msg = 'Descreva um pouco mais sua necessidade.';
    setError(input, msg);
    return !msg;
  }

  var fields = ['nome', 'email', 'mensagem'].map(function (n) { return form.elements[n]; });

  fields.forEach(function (f) {
    f.addEventListener('blur', function () { check(f); });
    f.addEventListener('input', function () { if (f.classList.contains('is-invalid')) check(f); });
  });

  form.addEventListener('submit', function (e) {
    if (sending) { e.preventDefault(); return; }

    var ok = fields.map(check).every(Boolean);
    if (!ok) {
      e.preventDefault();
      status.className = 'abcs-status is-error';
      status.textContent = 'Corrija os campos destacados e tente novamente.';
      var first = form.querySelector('.is-invalid');
      if (first) first.focus();
      return;
    }

    sending = true;
    btn.disabled = true;
    btn.querySelector('span').textContent = 'Enviando...';
    status.className = 'abcs-status';
    status.textContent = '';
    // segue o POST nativo; o retorno (sucesso/erro) é exibido pela página ./contatoRealizado
  });

  // Se o usuário voltar pelo histórico, libera o botão novamente
  window.addEventListener('pageshow', function (ev) {
    if (ev.persisted) {
      sending = false;
      btn.disabled = false;
      btn.querySelector('span').textContent = 'Enviar Mensagem Técnica';
    }
  });
})();
</script>

