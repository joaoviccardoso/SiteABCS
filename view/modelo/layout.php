<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>ABCS
    <?php echo($title); ?>
  </title>

  <link rel="icon" type="image/png" href="<?php echo($dot);?>/img/favicon.png" />

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
      };
      var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
          window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
      if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
      else window.addEventListener('load', loadDeferredStyles);
    </script>
  </body>

  <script async defer>
    function paginaCarregada() {
      document.getElementById("preloader_3").style.display = "none";
      document.getElementById("conteudo").style.display = 'block';
      document.getElementById("pagina").style.display = 'block';
    }
  
 </script>
  
  
  
</head>

<style>
  #conteudo,
  #pagina {
    display: none;
  }

  #preloader_3 {
    z-index: 100;
    position: absolute;
    top: 40%;
    left: 40%;
    margin-top: -40px;
    margin-left: -40px;
  }

  #preloader_3:before {
    width: 100px;
    height: 100px;
    border-radius: 100px;
    background: blue;
    content: '';
    position: absolute;
    background: #000066;
    animation: preloader_3_before 1.5s infinite ease-in-out;
  }

  #preloader_3:after {
    width: 100px;
    height: 100px;
    border-radius: 100px;
    background: blue;
    content: '';
    position: absolute;
    background: #777777;
    left: 110px;
    animation: preloader_3_after 1.5s infinite ease-in-out;
  }

  @keyframes preloader_3_before {
    0% {
      transform: translateX(0px) rotate(0deg)
    }
    50% {
      transform: translateX(200px) scale(1.2) rotate(225deg);
      background: #777777;
      border-radius: 0px;
    }
    100% {
      transform: translateX(0px) rotate(0deg)
    }
  }

  @keyframes preloader_3_after {
    0% {
      transform: translateX(0px)
    }
    50% {
      transform: translateX(-200px) scale(1.2) rotate(-225deg);
      background: #000066;
      border-radius: 0px;
    }
    100% {
      transform: translateX(0px);
    }
  }
</style>
<div id="preloader_3"></div>

<body onLoad="paginaCarregada();">

  <div id="conteudo">
    <nav class="navbar navbar-expand-md navbar-inverse">
      <a class="navbar-brand" href="<?php echo($dot);?>/">
        <img src='<?php echo($dot);?>/img/abcs_branco.png' alt='ABCS Informática' />
      </a>
      <button class="navbar-toggler bg-light text-dark" type="button" data-toggle="collapse" data-target="#navbar01" aria-controls="navbar01"
        aria-expanded="true" aria-label="Toggle navigation">
        <span>
          <i class="fa fa-bars" aria-hidden="true"></i>
        </span>
      </button>

      <div class="collapse navbar-collapse text-center" id ="navbar01" >
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-laptop" aria-hidden="true"></i>
              Sistemas
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
              <a class="dropdown-item" href="<?php echo($dot);?>/premium">ABCS Premium</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/mosaico">ABCS Mosaico</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/citrus">ABCS Citrus</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/nfe">ABCS NFe</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/sysin">ABCS SysIn</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/sat">ABCS SAT</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/cte">ABCS CTe</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/mdfe">ABCS MDFe</a>
              <a class="dropdown-item" href="http://www.santaficha.com.br/" target="_blank">SANTA FICHA</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.instagram.com/abcsinformatica/" , target="_blank">
              <i class="fa fa-instagram" aria-hidden="true"></i> Instagram
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo($dot);?>/contato">
              <i class="fa fa-envelope" aria-hidden="true"></i> Contato</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo($dot);?>/boleto">
              <i class="fa fa-barcode" aria-hidden="true"></i> Boleto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo($dot);?>/senha">
              <i class="fa fa-unlock" aria-hidden="true"></i> Senha</a>
          </li>
          <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
              Ajuda
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdown">
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/premium">ABCS Premium</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/mosaico">ABCS Mosaico</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/citrus">ABCS Citrus</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/nfe">ABCS NFe</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/sysin">ABCS SysIn</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/sat">ABCS SAT</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/cte">ABCS CTe</a>
              <a class="dropdown-item" href="<?php echo($dot);?>/ajuda/mdfe">ABCS MDFe</a>
              <a class="dropdown-item" href="http://www.santaficha.com.br/tutoriais" target="_blank">SANTA FICHA</a>
            </div>
          </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
         <!-- <li class="nav-item">
            <a class="nav-link bg-success text-warning" href="?php echo($dot);/bolaoabcs">
              <i class="fa fa-futbol-o" aria-hidden="true"></i> Bolão ABCS</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link bg-info" href="<?php echo($dot);?>/teamviewer" target="_blank" role="button">
              <i class="fa fa-desktop" aria-hidden="true"></i> TeamViewer</a>
          </li>
        </ul>
    </nav>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col">
            <p>ABCS Informática ©
              <?php echo date("Y"); ?></br>CNPJ: 00.246.242/0001-60 I.E.: 270.011.138.115
            </p>
         
          </div>
          <div class="col">
            <p>Conheça também:
              <a class="link" href="http://www.santaficha.com.br/" target="_blank">
                <img src='<?php echo($dot);?>/img/santaficha.png' height='30px' alt='Santa Ficha' />
              </a>
              e
              <a class="link" href="http://www.neolink.com.br/" target="_blank">
                <img src='<?php echo($dot);?>/img/neolink.png' height='30px' alt='Neolink Telecom' />
              </a>
            </p>
          </div>
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
