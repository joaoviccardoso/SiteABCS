<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>ABCS
    <?php echo($title); ?>
  </title>

  <link rel="icon" type="image/png" href="<?php echo($dot);?>/img/favicon.png" />
  <link rel="preload" as="image" href="<?php echo($dot);?>/img/1LogoABCSInfo.png">

  <meta property="og:title" content="ABCS <?php echo($title); ?>">
  <meta property="og:url" content="https://www.abcsinformatica.com.br">
  <meta property="og:image" content="https://www.abcsinformatica.com.br/img/abcs_azul_full.png">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="ABCS Informática">
  <meta name="description" content="ABCS <?php echo($title); ?>">
    <meta name="keywords" content="<?php echo($keywords); ?>">
  <meta name="author" content="ABCS Informática">
  <meta name="google-site-verification" content="LJerIVKKvKiJGEcnNvXXXf2IDDOQcsmAod074JVaZrc" />

  <meta name="theme-color" content="#000066">

  <link rel="shortcut icon" type="image/png" href="<?php echo($dot); ?>/img/favicon.png">

  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0">

  <!-- Fonte Montserrat (navbar, hero e footer) -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <noscript id="deferred-styles">
      <link rel="stylesheet" type="text/css" href="<?php echo($dot);?>/minify "/>
    </noscript>
    <script defer>
      var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("deferred-styles");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement)
        addStylesNode.parentElement.removeChild(addStylesNode);

        // CORREÇÃO: quando o CSS adiado terminar de carregar, recalcula o rodapé
        var links = replacement.querySelectorAll('link[rel="stylesheet"]');
        for (var i = 0; i < links.length; i++) {
          links[i].addEventListener('load', function () {
            if (typeof ajustaRodape === 'function') ajustaRodape();
          });
        }
      };
      var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
          window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
      if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
      else window.addEventListener('load', loadDeferredStyles);
    </script>
  </body>

  <script>
    // O footer é absoluto no fim da página; sua altura vira padding-bottom do body.
    function ajustaRodape() {
      var f = document.querySelector('.footer');
      if (f) document.body.style.paddingBottom = f.offsetHeight + 'px';
    }

    // NOVO: observa o footer e reajusta quando o tamanho dele mudar
    // (CSS adiado, fontes, resize, quebra de linha etc.)
    var rodapeObservado = false;
    function observaRodape() {
      var f = document.querySelector('.footer');
      if (!f || rodapeObservado) return;
      rodapeObservado = true;
      if (window.ResizeObserver) {
        new ResizeObserver(ajustaRodape).observe(f);
      }
    }

    // Progresso estimado a partir do carregamento dos recursos encontrados no HTML.
    // O percentual chega a 90% durante o carregamento e só vai a 100% no evento load.
    var totalRecursos = 0;
    var recursosCarregados = 0;
    var progressoExibido = 0;
    var recursosMonitorados = new WeakSet();

    function atualizarBarra() {
      var percentual = totalRecursos > 0
        ? Math.round((recursosCarregados / totalRecursos) * 90)
        : 5;

      percentual = Math.min(90, Math.max(progressoExibido, percentual));
      progressoExibido = percentual;

      var barra = document.querySelector('.loader-barra span');
      var texto = document.getElementById('loader-percent');

      if (barra) barra.style.width = percentual + '%';
      if (texto) texto.textContent = percentual + '%';
    }

    function monitorarRecurso(elemento) {
      if (recursosMonitorados.has(elemento)) return;

      var tag = elemento.tagName;
      var relevante =
        (tag === 'IMG') ||
        (tag === 'SCRIPT' && elemento.src) ||
        (tag === 'LINK' && elemento.rel && elemento.rel.toLowerCase() === 'stylesheet') ||
        tag === 'IFRAME' ||
        ((tag === 'VIDEO' || tag === 'AUDIO') && elemento.src);

      if (!relevante) return;

      recursosMonitorados.add(elemento);
      totalRecursos++;

      var finalizado = false;

      function concluirRecurso() {
        if (finalizado) return;
        finalizado = true;
        recursosCarregados++;
        atualizarBarra();
      }

      elemento.addEventListener('load', concluirRecurso, { once: true });
      elemento.addEventListener('error', concluirRecurso, { once: true });

      // Recursos em cache podem já ter terminado antes da instalação do listener.
      if (
        (tag === 'IMG' && elemento.complete) ||
        (tag === 'LINK' && elemento.sheet) ||
        (tag === 'SCRIPT' && elemento.readyState === 'complete') ||
        ((tag === 'VIDEO' || tag === 'AUDIO') && elemento.readyState >= 2)
      ) {
        concluirRecurso();
      }
    }

    function iniciarMonitoramento() {
      document.querySelectorAll('img, script[src], link[rel="stylesheet"], iframe, video[src], audio[src]')
        .forEach(monitorarRecurso);

      // Também acompanha recursos adicionados dinamicamente, como folhas de estilo.
      var observador = new MutationObserver(function (mutacoes) {
        mutacoes.forEach(function (mutacao) {
          mutacao.addedNodes.forEach(function (no) {
            if (no.nodeType !== 1) return;

            monitorarRecurso(no);
            if (no.querySelectorAll) {
              no.querySelectorAll('img, script[src], link[rel="stylesheet"], iframe, video[src], audio[src]')
                .forEach(monitorarRecurso);
            }
          });
        });
      });

      observador.observe(document.documentElement, { childList: true, subtree: true });
      atualizarBarra();
    }

    function paginaCarregada() {
      var pre = document.getElementById('preloader_3');
      var conteudo = document.getElementById('conteudo');
      var pagina = document.getElementById('pagina');

      // O evento load já ocorreu. Aguarda também a conclusão das fontes, quando suportado.
      var fontesProntas = (document.fonts && document.fonts.ready)
        ? document.fonts.ready
        : Promise.resolve();

      fontesProntas.then(function () {
        progressoExibido = 100;

        var barra = document.querySelector('.loader-barra span');
        var texto = document.getElementById('loader-percent');
        if (barra) barra.style.width = '100%';
        if (texto) texto.textContent = '100%';

        if (conteudo) conteudo.style.display = 'block';
        if (pagina) pagina.style.display = 'block';

        ajustaRodape();
        observaRodape();   // CORREÇÃO: mantém o padding sempre sincronizado com o footer
        pre.classList.add('saindo');

        setTimeout(function () {
          pre.style.display = 'none';
        }, 400);
      });
    }

    // Inicia imediatamente para conseguir registrar também os scripts e imagens
    // que serão encontrados mais adiante durante a leitura do HTML.
    iniciarMonitoramento();

    window.addEventListener('resize', ajustaRodape);
  </script>
  
  
  
</head>

<style>
  #conteudo,
#pagina {
  display: none;
}

#preloader_3 {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 28px;
  background: #fff;
  transition: opacity .4s ease, visibility .4s ease;
}

#preloader_3.saindo {
  opacity: 0;
  visibility: hidden;
}

.loader-logo {
  position: relative;
  width: 260px;
  max-width: 70vw;
}

.loader-logo img {
  display: block;
  width: 100%;
  height: auto;
}

/* logo apagado ao fundo */
.loader-logo .logo-base {
  filter: grayscale(1) opacity(.2);
}

/* logo colorido que vai sendo revelado */
.loader-logo .logo-cor {
  position: absolute;
  top: 0;
  left: 0;
  clip-path: inset(0 100% 0 0);
  animation: logo-preenche 1.8s ease-in-out infinite;
}

@keyframes logo-preenche {
  0%   { clip-path: inset(0 100% 0 0); }
  50%  { clip-path: inset(0 0 0 0); }
  100% { clip-path: inset(0 0 0 100%); }
}

/* Barra de progresso vinculada ao carregamento dos recursos */
.loader-barra {
  width: 180px;
  height: 4px;
  border-radius: 4px;
  background: #e6e6ee;
  overflow: hidden;
}

.loader-barra span {
  display: block;
  width: 5%;
  height: 100%;
  border-radius: 4px;
  background: #000066;
  transition: width .25s ease;
}

.loader-percent {
  margin-top: -18px;
  color: #000066;
  font-family: Montserrat, sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .04em;
}

@media (prefers-reduced-motion: reduce) {
  .loader-logo .logo-cor { animation: none; clip-path: inset(0 0 0 0); }
  .loader-barra span { transition: none; }
}
</style>
<div id="preloader_3">
  <div class="loader-logo">
    <img class="logo-base" src="<?php echo($dot);?>/img/1LogoABCSInfo.png" alt="">
    <img class="logo-cor" src="<?php echo($dot);?>/img/1LogoABCSInfo.png" alt="ABCS Informática">
  </div>
  <div class="loader-barra"><span></span></div>
  <div class="loader-percent" id="loader-percent">5%</div>
</div>

<body onLoad="paginaCarregada();">

  <div id="conteudo">
<?php
  // rota atual, para marcar o item ativo do menu
  $mensagemWhatsApp = "Olá! Acessei o site da ABCS Informática e gostaria de mais informações sobre os serviços.";
  $linkWhatsApp = "https://wa.me/551938661100?text=" . urlencode($mensagemWhatsApp);
  $atual = explode('?', $_SERVER['REQUEST_URI']);
  $atual = trim($atual[0], '/');
  $partes = explode('/', $atual);
  $atual = $partes[0];
  $ativo = function ($rotas) use ($atual) {
    return in_array($atual, (array) $rotas) ? ' active' : '';
  };
?>
    <nav class="navbar navbar-expand-lg navbar-abcs">
      <a class="navbar-brand" href="<?php echo($dot);?>/">
        <img class="img-nav" src="<?php echo($dot);?>/img/1LogoABCSInfo.png" alt="ABCS Informática">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar01" aria-controls="navbar01" aria-expanded="false" aria-label="Abrir menu">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbar01">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo(array('', 'index')); ?>" href="<?php echo($dot);?>/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo(array('sobre', 'quemsomos')); ?>" href="<?php echo($dot);?>/sobre">Sobre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo(array('sistemas', 'premium', 'mosaico', 'citrus', 'nfe', 'sysin', 'sat', 'cte', 'mdfe')); ?>" href="<?php echo($dot);?>/sistemas">Sistemas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo(array('senha', 'acesso')); ?>" href="<?php echo($dot);?>/senha">Senha</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo('boleto'); ?>" href="<?php echo($dot);?>/boleto">Boleto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo(array('manutencao')); ?>" href="<?php echo($dot);?>/manutencao">Manutenção</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ativo('contato'); ?>" href="<?php echo($dot);?>/contato">Contato</a>
          </li>
        </ul>

        <!-- botão WhatsApp no celular (dentro do menu aberto) -->
        <a class="btn-whatsapp d-lg-none"
          href="<?php echo $linkWhatsApp; ?>"
          target="_blank"
          rel="noopener">
            <i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
        </a>
      </div>

      <!-- botão WhatsApp no desktop (à direita) -->
        <div class="nav-cta d-none d-lg-flex">
            <a class="btn-whatsapp"
              href="<?php echo $linkWhatsApp; ?>"
              target="_blank"
              rel="noopener">
                <i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
            </a>
        </div>
      </div>
    </nav>

    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-6 col-md-3 footer-col">
            <h4 class="footer-brand">ABCS Informática</h4>
            <p class="footer-text">Excelência em serviços de TI e desenvolvimento de softwares personalizados.</p>
          </div>

          <div class="col-6 col-md-3 footer-col">
            <h4 class="footer-title">Serviços</h4>
            <ul class="footer-list">
              <li><a href="<?php echo($dot);?>/#suporte">Suporte Técnico</a></li>
              <li><a href="<?php echo($dot);?>/#infraestrutura">Infraestrutura</a></li>
              <li><a href="<?php echo($dot);?>/#consultoria">Consultoria</a></li>
            </ul>
          </div>

          <div class="col-6 col-md-3 footer-col">
            <h4 class="footer-title">Links úteis</h4>
            <ul class="footer-list">
              <li><a href="<?php echo($dot);?>/ajuda">Central de ajuda</a></li>
              <li><a href="<?php echo($dot);?>/teamviewer" target="_blank">Suporte remoto</a></li>
              <li><a href="<?php echo($dot);?>/downloads">Downloads</a></li>
            </ul>
          </div>

          <div class="col-6 col-md-3 footer-col">
            <h4 class="footer-title">Contato</h4>
            <ul class="footer-list">
              <li><i class="fa fa-map-marker" aria-hidden="true"></i> Endereço da empresa, nº - Bairro</li>
              <li><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+551938661100">(19) 3866-1100</a></li>
              <li><i class="fa fa-instagram" aria-hidden="true"></i> <a href="https://www.instagram.com/abcsinformatica/" target="_blank" rel="noopener">@abcsinformatica</a></li>
            </ul>
          </div>
        </div>

        <div class="footer-bottom">
          <p>&copy; <?php echo date("Y"); ?> ABCS Informática. Todos os direitos reservados.</p>
          <p>CNPJ: 00.246.242/0001-60 &middot; I.E.: 270.011.138.115</p>
        </div>
      </div>
    </footer>
    </div>
</body>

</html>
<script defer src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
  crossorigin="anonymous"></script>
<script  defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
  crossorigin="anonymous"></script>
<script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
  crossorigin="anonymous"></script>
<!--<script async>
  (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
      m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
  ga('create', 'UA-97705397-1', 'auto');
  ga('send', 'pageview');
</script>-->