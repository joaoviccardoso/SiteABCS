<?php
// Garante que o navegador e os buscadores recebam o status HTTP correto
if (!headers_sent()) {
    http_response_code(500);
}

// Código de referência para o usuário informar ao suporte (opcional)
$codigo = strtoupper(substr(md5(uniqid('', true)), 0, 8));
// error_log("Erro 500 - ref {$codigo} - " . ($_SERVER['REQUEST_URI'] ?? ''));
?>
<style>
  #pagina {
    --e-bg: #ffffff;
    --e-borda: #e3e6ea;
    --e-texto: #1f2933;
    --e-suave: #5f6b7a;
    --e-destaque: #c2410c;
    --e-destaque-bg: #fff1e8;
    --e-botao: #1f2933;
    --e-botao-texto: #ffffff;

    max-width: 560px;
    margin: 8vh auto;
    padding: 0 1rem;
    color: var(--e-texto);
    text-align: left;
  }

  #pagina .erro-card {
    display: flex;
    gap: 1.25rem;
    padding: 2rem;
    background: var(--e-bg);
    border: 1px solid var(--e-borda);
    border-left: 5px solid var(--e-destaque);
    border-radius: 6px;
  }

  #pagina .erro-icone {
    flex: 0 0 52px;
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: var(--e-destaque);
    background: var(--e-destaque-bg);
    border-radius: 50%;
  }

  #pagina .erro-codigo {
    margin: 0 0 .25rem;
    font-size: .9rem;
    font-weight: 600;
    color: var(--e-destaque);
  }

  #pagina h1 {
    margin: 0 0 .75rem;
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.25;
  }

  #pagina p {
    margin: 0 0 1.25rem;
    line-height: 1.6;
    color: var(--e-suave);
  }

  #pagina .erro-acoes {
    display: flex;
    flex-wrap: wrap;
    gap: .75rem;
    margin-bottom: 1.25rem;
  }

  #pagina .erro-btn {
    display: inline-block;
    padding: .6rem 1.1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 4px;
    border: 1px solid var(--e-botao);
    transition: background-color .15s, color .15s;
  }

  #pagina .erro-btn-primario {
    background: var(--e-botao);
    color: var(--e-botao-texto);
  }

  #pagina .erro-btn-primario:hover {
    background: transparent;
    color: var(--e-botao);
  }

  #pagina .erro-btn-secundario {
    background: transparent;
    color: var(--e-botao);
  }

  #pagina .erro-btn-secundario:hover {
    background: var(--e-botao);
    color: var(--e-botao-texto);
  }

  #pagina .erro-btn:focus-visible {
    outline: 3px solid var(--e-destaque);
    outline-offset: 2px;
  }

  #pagina .erro-ref {
    margin: 0;
    font-size: .85rem;
    color: var(--e-suave);
  }

  #pagina .erro-ref code {
    padding: .1rem .4rem;
    color: var(--e-texto);
    background: var(--e-destaque-bg);
    border-radius: 3px;
  }

  @media (prefers-color-scheme: dark) {
    #pagina {
      --e-bg: #1b222b;
      --e-borda: #2f3946;
      --e-texto: #eef1f4;
      --e-suave: #a8b3c0;
      --e-destaque: #fb923c;
      --e-destaque-bg: #3a2517;
      --e-botao: #eef1f4;
      --e-botao-texto: #1b222b;
    }
  }

  @media (max-width: 480px) {
    #pagina .erro-card {
      flex-direction: column;
      padding: 1.5rem;
    }
  }
</style>

<div id="pagina" role="alert">
  <div class="erro-card">
    <div class="erro-icone">
      <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    </div>

    <div>
      <p class="erro-codigo">Erro 500</p>
      <h1>Algo deu errado do nosso lado</h1>
      <p>
        O servidor não conseguiu concluir sua solicitação.
        Você não fez nada de errado. Tente novamente em alguns instantes.
      </p>

      <div class="erro-acoes">
        <a class="erro-btn erro-btn-primario" href="javascript:location.reload()">Tentar novamente</a>
        <a class="erro-btn erro-btn-secundario" href="../">Voltar ao início</a>
      </div>

      <p class="erro-ref">
        Se o problema continuar, informe o código
        <code><?= htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8') ?></code> ao suporte.
      </p>
    </div>
  </div>
</div>