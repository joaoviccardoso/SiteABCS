<style>
    .envio {
        --envio-verde: #1c7c4d;
        --envio-verde-escuro: #14583a;
        --envio-verde-claro: #e7f4ec;
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
        border-top: 5px solid var(--envio-verde);
        border-radius: 8px;
        padding: 40px 32px 32px;
        box-shadow: 0 8px 24px rgba(20, 40, 30, .08);
    }

    .envio-selo {
        width: 84px;
        height: 84px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: var(--envio-verde-claro);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .envio-selo svg {
        width: 44px;
        height: 44px;
        fill: none;
        stroke: var(--envio-verde);
        stroke-width: 3.2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .envio-selo path {
        stroke-dasharray: 40;
        stroke-dashoffset: 40;
        animation: envio-tracar .6s ease-out .25s forwards;
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
        color: var(--envio-verde-escuro);
        font-weight: 600;
        white-space: nowrap;
    }

    .envio-botao {
        display: inline-block;
        margin-top: 28px;
        padding: 12px 28px;
        border-radius: 6px;
        background: var(--envio-verde);
        color: #fff;
        font-weight: 600;
        text-decoration: none;
        transition: background-color .15s ease;
    }

    .envio-botao:hover,
    .envio-botao:focus {
        background: var(--envio-verde-escuro);
        color: #fff;
        text-decoration: none;
    }

    .envio-botao:focus-visible {
        outline: 3px solid #8fd0ad;
        outline-offset: 2px;
    }

    @media (max-width: 480px) {
        .envio { margin: 24px auto; }
        .envio-cartao { padding: 32px 20px 24px; }
        .envio-titulo { font-size: 1.5rem; }
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
    <div class="envio-cartao" role="status">
        <div class="envio-selo" aria-hidden="true">
            <svg viewBox="0 0 48 48"><path d="M10 25l10 10 18-21"/></svg>
        </div>

        <h1 class="envio-titulo">Mensagem enviada</h1>
        <p class="envio-texto">
            Recebemos o seu contato. Nossa equipe vai analisar e responder para o e-mail que você informou.
        </p>

        <p class="envio-urgente">
            É urgente? Ligue para <a href="tel:+551938661100">(19) 3866-1100</a>.
        </p>

        <a class="envio-botao" href="./">Voltar ao site</a>
    </div>
</div>