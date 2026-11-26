<style>
    .envio {
        --envio-vermelho: #b42318;
        --envio-vermelho-escuro: #8a1a11;
        --envio-vermelho-claro: #fdeceb;
        --envio-texto: #1f2933;
        --envio-suave: #5b6776;
        --envio-borda: #dfe5ea;

        max-width: 560px;
        margin: 48px auto;
        padding: 0 16px;
        color: var(--envio-texto);
        text-align: center;
    }

    .envio-cartao {
        background: #fff;
        border: 1px solid var(--envio-borda);
        border-top: 5px solid var(--envio-vermelho);
        border-radius: 8px;
        padding: 40px 32px 32px;
        box-shadow: 0 8px 24px rgba(40, 20, 20, .08);
    }

    .envio-selo {
        width: 84px;
        height: 84px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: var(--envio-vermelho-claro);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .envio-selo svg {
        width: 40px;
        height: 40px;
        fill: none;
        stroke: var(--envio-vermelho);
        stroke-width: 3.2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .envio-selo path {
        stroke-dasharray: 36;
        stroke-dashoffset: 36;
        animation: envio-tracar .45s ease-out forwards;
    }

    .envio-selo path:nth-child(2) {
        animation-delay: .3s;
    }

    @keyframes envio-tracar {
        to { stroke-dashoffset: 0; }
    }

    .envio-titulo {
        margin: 0 0 12px;
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.2;
        color: var(--envio-texto);
    }

    .envio-texto {
        margin: 0 auto;
        max-width: 42ch;
        font-size: 1.05rem;
        line-height: 1.6;
        color: var(--envio-suave);
    }

    .envio-urgente {
        margin: 24px 0 0;
        padding-top: 20px;
        border-top: 1px solid var(--envio-borda);
        font-size: .95rem;
        color: var(--envio-suave);
    }

    .envio-urgente a {
        color: var(--envio-vermelho-escuro);
        font-weight: 600;
        white-space: nowrap;
    }

    .envio-acoes {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
        margin-top: 28px;
    }

    .envio-botao {
        display: inline-block;
        padding: 12px 24px;
        border: 1px solid var(--envio-vermelho);
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color .15s ease, color .15s ease;
    }

    .envio-botao-primario {
        background: var(--envio-vermelho);
        color: #fff;
    }

    .envio-botao-primario:hover,
    .envio-botao-primario:focus {
        background: var(--envio-vermelho-escuro);
        border-color: var(--envio-vermelho-escuro);
        color: #fff;
        text-decoration: none;
    }

    .envio-botao-secundario {
        background: transparent;
        color: var(--envio-vermelho);
    }

    .envio-botao-secundario:hover,
    .envio-botao-secundario:focus {
        background: var(--envio-vermelho-claro);
        color: var(--envio-vermelho-escuro);
        text-decoration: none;
    }

    .envio-botao:focus-visible {
        outline: 3px solid #f0a8a2;
        outline-offset: 2px;
    }

    @media (max-width: 480px) {
        .envio { margin: 24px auto; }
        .envio-cartao { padding: 32px 20px 24px; }
        .envio-titulo { font-size: 1.5rem; }
        .envio-acoes { flex-direction: column; }
        .envio-botao { display: block; }
    }

    @media (prefers-reduced-motion: reduce) {
        .envio-selo path {
            animation: none;
            stroke-dashoffset: 0;
        }
    }
</style>

<div class="envio" id="pagina">
    <div class="envio-cartao" role="alert">
        <div class="envio-selo" aria-hidden="true">
            <svg viewBox="0 0 48 48"><path d="M14 14l20 20"/><path d="M34 14L14 34"/></svg>
        </div>

        <h1 class="envio-titulo">Não foi possível enviar</h1>
        <p class="envio-texto">
            Sua mensagem não foi enviada. Confira se nome, e-mail, assunto e mensagem estão preenchidos e tente de novo.
        </p>

        <div class="envio-acoes">
            <a class="envio-botao envio-botao-primario" href="javascript:history.back()">Tentar novamente</a>
            <a class="envio-botao envio-botao-secundario" href="./">Voltar ao site</a>
        </div>

        <p class="envio-urgente">
            Se o problema continuar, ligue para <a href="tel:+551938661100">(19) 3866-1100</a>.
        </p>
    </div>
</div>