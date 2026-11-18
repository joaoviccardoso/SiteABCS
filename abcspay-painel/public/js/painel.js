// Comportamentos do painel. Sem etapa de build: servido como esta.

// --- Menu do celular --------------------------------------------------------

// Abaixo de 960 px o menu vira uma lista aberta pelo botao do topo. Sem
// JavaScript ele fica sempre aberto: e a classe "js" do <html> que o fecha.
document.querySelectorAll('[data-botao-menu]').forEach((botao) => {
    const topo = botao.closest('.topo');
    const aberto = () => topo.classList.contains('menu-aberto');
    const alternar = (abrir) => {
        topo.classList.toggle('menu-aberto', abrir);
        botao.setAttribute('aria-expanded', String(abrir));
        botao.setAttribute('aria-label', abrir ? 'Fechar menu' : 'Abrir menu');
    };

    botao.addEventListener('click', () => alternar(!aberto()));
    document.addEventListener('keydown', (evento) => {
        if (evento.key !== 'Escape' || !aberto()) return;
        alternar(false);
        botao.focus();
    });
    document.addEventListener('pointerdown', (evento) => {
        if (aberto() && !topo.contains(evento.target)) alternar(false);
    });
    // Voltou a caber na barra: ali o menu nao tem estado aberto ou fechado.
    window.matchMedia('(min-width: 961px)').addEventListener('change', (consulta) => {
        if (consulta.matches) alternar(false);
    });
});

document.addEventListener('click', (evento) => {
    // "Ver" / "Ocultar" nos campos de segredo.
    const botao = evento.target.closest('[data-alternar-segredo]');
    if (!botao) return;

    const campo = document.getElementById(botao.dataset.alternarSegredo);
    const revelar = campo.type === 'password';
    campo.type = revelar ? 'text' : 'password';
    botao.textContent = revelar ? 'Ocultar' : 'Ver';
});

document.addEventListener('input', (evento) => {
    const alvo = evento.target;

    // Seletor de cor -> campo hexadecimal.
    if (alvo.matches('[data-cor-para]')) {
        document.getElementById(alvo.dataset.corPara).value = alvo.value.toUpperCase();
        return;
    }

    // Campo hexadecimal -> seletor de cor, quando o codigo estiver completo.
    const seletor = document.querySelector(`[data-cor-para="${alvo.id}"]`);
    if (seletor && /^#[0-9A-Fa-f]{6}$/.test(alvo.value)) {
        seletor.value = alvo.value.toLowerCase();
    }
});

// --- Envio: confirmacao e "Aguarde, salvando..." ---------------------------

document.addEventListener('submit', (evento) => {
    const formulario = evento.target;

    // Acao sem volta (gerar codigo, liberar vinculo): pergunta antes. Com o sim,
    // o formulario e reenviado e passa por aqui ja confirmado.
    const mensagem = formulario.dataset.confirmar;
    if (mensagem && formulario.dataset.confirmado !== '1') {
        evento.preventDefault();
        const botao = evento.submitter || formulario.querySelector('[type="submit"]');
        confirmarAcao(mensagem, botao).then((sim) => {
            if (!sim) return;
            formulario.dataset.confirmado = '1';
            if (formulario.requestSubmit) formulario.requestSubmit(botao || undefined);
            else formulario.submit();
        });
        return;
    }
    delete formulario.dataset.confirmado;

    if (!formulario.hasAttribute('data-salvando')) return;

    // Segundo clique enquanto o primeiro envio anda: com arquivo de imagem o
    // envio demora, e cada clique a mais seria um salvamento a mais.
    if (formulario.dataset.enviando === '1') {
        evento.preventDefault();
        return;
    }
    formulario.dataset.enviando = '1';
    formulario.querySelectorAll('button[type="submit"]').forEach((botao) => {
        botao.disabled = true;
    });
    avisoSalvando(true);
});

// Voltar pelo historico traz a pagina congelada, ainda com o aviso na tela.
window.addEventListener('pageshow', (evento) => {
    if (!evento.persisted) return;
    avisoSalvando(false);
    document.querySelectorAll('form[data-salvando]').forEach((formulario) => {
        delete formulario.dataset.enviando;
        formulario.querySelectorAll('button[type="submit"]').forEach((botao) => {
            botao.disabled = false;
        });
    });
});

function avisoSalvando(visivel) {
    let aviso = document.querySelector('.salvando');
    if (!aviso && visivel) {
        aviso = document.createElement('div');
        aviso.className = 'salvando';
        aviso.setAttribute('role', 'status');
        aviso.innerHTML = '<div class="salvando-caixa"><span class="giro" aria-hidden="true"></span>Aguarde, salvando...</div>';
        document.body.append(aviso);
    }
    if (aviso) aviso.hidden = !visivel;
}

/**
 * Pergunta antes de uma acao sem volta, num dialogo do painel: o confirm() do
 * navegador mostra o endereco do site no titulo e ignora o tema. O titulo e o
 * botao de confirmar levam o texto do botao clicado ("Liberar vinculo"), em
 * vermelho quando ele e de perigo. Sem <dialog>, fica o confirm().
 */
function confirmarAcao(mensagem, botao) {
    if (typeof HTMLDialogElement !== 'function') {
        return Promise.resolve(window.confirm(mensagem));
    }

    let dialogo = document.querySelector('.dialogo');
    if (!dialogo) {
        dialogo = document.createElement('dialog');
        dialogo.className = 'dialogo';
        dialogo.setAttribute('aria-labelledby', 'dialogo-titulo');
        dialogo.setAttribute('aria-describedby', 'dialogo-texto');
        dialogo.innerHTML = `
            <form method="dialog">
                <h2 class="dialogo-titulo" id="dialogo-titulo"></h2>
                <p class="dialogo-texto" id="dialogo-texto"></p>
                <div class="dialogo-acoes">
                    <button type="submit" value="nao" class="botao-secundario">Cancelar</button>
                    <button type="submit" value="sim" class="botao" data-sim></button>
                </div>
            </form>`;
        // Toque fora da caixa cancela, como o Esc.
        dialogo.addEventListener('click', (evento) => {
            if (evento.target === dialogo) dialogo.close('nao');
        });
        document.body.append(dialogo);
    }

    const acao = botao?.textContent.trim() || 'Confirmar';
    const sim = dialogo.querySelector('[data-sim]');
    dialogo.querySelector('.dialogo-titulo').textContent = acao;
    dialogo.querySelector('.dialogo-texto').textContent = mensagem;
    sim.textContent = acao;
    sim.classList.toggle('botao-destrutivo', Boolean(botao?.classList.contains('botao-perigo')));

    dialogo.returnValue = '';
    dialogo.showModal();
    return new Promise((resolve) => {
        dialogo.addEventListener('close', () => resolve(dialogo.returnValue === 'sim'), { once: true });
    });
}

// --- Imagem por endereco ou por arquivo -------------------------------------

/** O mesmo limite que o servidor aplica: avisar aqui poupa um envio perdido. */
const LIMITE_ARQUIVO = 2 * 1024 * 1024;

document.querySelectorAll('[data-campo-imagem]').forEach((campo) => {
    const url = campo.querySelector('[data-url-imagem]');
    const arquivo = campo.querySelector('[data-arquivo-imagem]');
    const miniatura = campo.querySelector('[data-miniatura]');
    const nomeArquivo = campo.querySelector('[data-nome-arquivo]');
    const erro = campo.querySelector('[data-erro-imagem]');
    let enderecoLocal = null;

    const mostrarErro = (texto) => {
        erro.textContent = texto || '';
        erro.hidden = !texto;
    };

    const soltarLocal = () => {
        if (enderecoLocal) URL.revokeObjectURL(enderecoLocal);
        enderecoLocal = null;
    };

    // Avisa quem desenha a imagem - a miniatura aqui, o editor de enquadramento
    // no caso da imagem promocional.
    const avisar = (endereco) => {
        mostrarErro(null);
        if (miniatura) {
            if (endereco) miniatura.src = endereco;
            else miniatura.removeAttribute('src');
            miniatura.hidden = !endereco;
        }
        campo.dispatchEvent(new CustomEvent('imagem-alterada', { detail: { endereco } }));
    };

    const falhou = () => mostrarErro('Nao foi possivel carregar a imagem deste endereco.');
    miniatura?.addEventListener('error', () => {
        if (!miniatura.getAttribute('src')) return;
        miniatura.hidden = true;
        falhou();
    });
    campo.addEventListener('imagem-falhou', falhou);

    url.addEventListener('change', () => {
        arquivo.value = '';
        nomeArquivo.textContent = '';
        soltarLocal();
        avisar(url.value.trim());
    });

    arquivo.addEventListener('change', () => {
        const escolhido = arquivo.files[0];
        if (!escolhido) return;
        if (escolhido.size > LIMITE_ARQUIVO) {
            arquivo.value = '';
            mostrarErro('O arquivo passa de 2 MB. Reduza a imagem e envie de novo.');
            return;
        }
        soltarLocal();
        enderecoLocal = URL.createObjectURL(escolhido);
        nomeArquivo.textContent = `${escolhido.name} - vai ao salvar`;
        avisar(enderecoLocal);
    });

    campo.querySelector('[data-remover-imagem]').addEventListener('click', () => {
        url.value = '';
        arquivo.value = '';
        nomeArquivo.textContent = '';
        soltarLocal();
        avisar('');
    });
});

// --- Enquadramento da imagem promocional ------------------------------------

document.querySelectorAll('[data-editor-imagem]').forEach(iniciarEditor);

function iniciarEditor(editor) {
    const formulario = editor.closest('form');
    const campo = (nome) => formulario.querySelector(`[name="${nome}"]`);
    const previa = editor.querySelector('[data-previa]');
    const janela = editor.querySelector('[data-janela]');
    const imagem = editor.querySelector('[data-imagem-previa]');
    const semImagem = editor.querySelector('[data-sem-imagem]');
    const areaCartao = editor.querySelector('[data-area-cartao]');
    const cartao = editor.querySelector('[data-cartao]');
    const deslizante = editor.querySelector('[data-zoom-deslizante]');
    const campoImagem = formulario.querySelector('[data-campo-imagem][data-nome="imagem_promocional_url"]');
    const modo = campo('modo_imagem');
    const zoom = campo('imagem_zoom');
    const deslocX = campo('imagem_desloc_x');
    const deslocY = campo('imagem_desloc_y');
    const corFundo = campo('cor_fundo');
    const corPrimaria = campo('cor_primaria');

    // Geometria da tela de identificacao do totem (TotemScreen.kt) - mudou
    // la, muda aqui. Numa Column do Compose o fillMaxHeight mede sobre o que
    // sobrou: a folga de baixo e fracao do que resta depois da area do cartao,
    // e a imagem fica com todo o resto, em cima.
    const ALTURA_AREA_CARTAO = 0.509;
    const FOLGA_INFERIOR = 0.195;
    const FRACAO_IMAGEM = 1 - ALTURA_AREA_CARTAO - FOLGA_INFERIOR * (1 - ALTURA_AREA_CARTAO);

    // Limites do enquadramento no admin do app (AdminViewModel.kt).
    const ZOOM_MINIMO = 0.2;
    const ZOOM_MAXIMO = 4;
    const DESLOC_MAXIMO = 1;

    areaCartao.style.top = `${FRACAO_IMAGEM * 100}%`;
    areaCartao.style.height = `${ALTURA_AREA_CARTAO * 100}%`;
    semImagem.style.top = `${(FRACAO_IMAGEM / 2) * 100}%`;

    const numero = (entrada, padrao) => {
        const valor = parseFloat(entrada.value);
        return Number.isFinite(valor) ? valor : padrao;
    };
    const limitar = (valor, minimo, maximo) => Math.min(maximo, Math.max(minimo, valor));
    const cor = (entrada) => (/^#[0-9A-Fa-f]{6}$/.test(entrada.value) ? entrada.value : null);

    const estado = {
        zoom: limitar(numero(zoom, 1), ZOOM_MINIMO, ZOOM_MAXIMO),
        x: limitar(numero(deslocX, 0), -DESLOC_MAXIMO, DESLOC_MAXIMO),
        y: limitar(numero(deslocY, 0), -DESLOC_MAXIMO, DESLOC_MAXIMO),
        carregada: false,
    };

    const escrever = () => {
        zoom.value = +estado.zoom.toFixed(3);
        deslocX.value = +estado.x.toFixed(4);
        deslocY.value = +estado.y.toFixed(4);
        deslizante.value = estado.zoom;
    };

    // Area da imagem no modo em uso: a faixa de cima ou a tela inteira.
    const area = () => {
        const largura = previa.clientWidth;
        const altura = previa.clientHeight;
        return modo.value === 'FUNDO' ? { largura, altura } : { largura, altura: altura * FRACAO_IMAGEM };
    };

    function desenhar() {
        const fundo = modo.value === 'FUNDO';
        previa.style.backgroundColor = cor(corFundo) || editor.dataset.fundoPadrao;
        cartao.style.borderColor = cor(corPrimaria) || editor.dataset.primariaPadrao;
        janela.style.height = fundo ? '100%' : `${FRACAO_IMAGEM * 100}%`;
        imagem.hidden = !estado.carregada;
        semImagem.hidden = estado.carregada;
        previa.classList.toggle('com-imagem', estado.carregada);
        if (!estado.carregada) return;

        // As contas do ImagemEnquadrada.kt. O Coil entrega o bitmap ja
        // ajustado a area (Scale.FIT com Precision.EXACT); no topo o Inside nao
        // mexe nele - a imagem aparece inteira, ancorada em cima -, e no fundo
        // o Crop a amplia ate cobrir a tela, centralizada. O zoom multiplica
        // essa escala, e o deslocamento e fracao da propria area.
        const { largura, altura } = area();
        const base = fundo
            ? Math.max(largura / imagem.naturalWidth, altura / imagem.naturalHeight)
            : Math.min(largura / imagem.naturalWidth, altura / imagem.naturalHeight);
        const w = imagem.naturalWidth * base * estado.zoom;
        const h = imagem.naturalHeight * base * estado.zoom;

        imagem.style.width = `${w}px`;
        imagem.style.height = `${h}px`;
        imagem.style.left = `${(largura - w) / 2 + estado.x * largura}px`;
        imagem.style.top = `${(fundo ? (altura - h) / 2 : 0) + estado.y * altura}px`;
    }

    function carregar(endereco) {
        estado.carregada = false;
        if (endereco) imagem.src = endereco;
        else imagem.removeAttribute('src');
        desenhar();
    }

    imagem.addEventListener('load', () => {
        estado.carregada = true;
        desenhar();
    });
    imagem.addEventListener('error', () => {
        if (!imagem.getAttribute('src')) return;
        estado.carregada = false;
        desenhar();
        campoImagem?.dispatchEvent(new CustomEvent('imagem-falhou'));
    });

    const centralizar = () => {
        estado.zoom = 1;
        estado.x = 0;
        estado.y = 0;
        escrever();
        desenhar();
    };

    // Imagem nova recomeca do zero, como no admin do app: o enquadramento da
    // anterior nao vale para ela.
    campoImagem?.addEventListener('imagem-alterada', (evento) => {
        centralizar();
        carregar(evento.detail.endereco);
    });

    editor.querySelector('[data-centralizar]').addEventListener('click', centralizar);

    // Os campos numericos atualizam a previa sem ser reescritos enquanto se
    // digita; so o arrasto, a roda e o deslizante escrevem neles.
    deslizante.addEventListener('input', () => {
        estado.zoom = parseFloat(deslizante.value);
        escrever();
        desenhar();
    });
    zoom.addEventListener('input', () => {
        estado.zoom = limitar(numero(zoom, 1), ZOOM_MINIMO, ZOOM_MAXIMO);
        deslizante.value = estado.zoom;
        desenhar();
    });
    deslocX.addEventListener('input', () => {
        estado.x = limitar(numero(deslocX, 0), -DESLOC_MAXIMO, DESLOC_MAXIMO);
        desenhar();
    });
    deslocY.addEventListener('input', () => {
        estado.y = limitar(numero(deslocY, 0), -DESLOC_MAXIMO, DESLOC_MAXIMO);
        desenhar();
    });
    modo.addEventListener('change', desenhar);

    // O seletor de cor atualiza o campo por codigo, sem disparar evento: a
    // previa redesenha no quadro seguinte, com o valor ja copiado.
    formulario.addEventListener('input', (evento) => {
        if (evento.target.closest('.cor')) requestAnimationFrame(desenhar);
    });

    // Arrasto: um pixel do mouse e um pixel da previa, na area do modo em uso.
    let arrasto = null;
    previa.addEventListener('pointerdown', (evento) => {
        if (!estado.carregada || evento.button !== 0) return;
        arrasto = { x: evento.clientX, y: evento.clientY };
        previa.setPointerCapture(evento.pointerId);
        previa.classList.add('arrastando');
        evento.preventDefault();
    });
    previa.addEventListener('pointermove', (evento) => {
        if (!arrasto) return;
        const { largura, altura } = area();
        estado.x = limitar(estado.x + (evento.clientX - arrasto.x) / largura, -DESLOC_MAXIMO, DESLOC_MAXIMO);
        estado.y = limitar(estado.y + (evento.clientY - arrasto.y) / altura, -DESLOC_MAXIMO, DESLOC_MAXIMO);
        arrasto = { x: evento.clientX, y: evento.clientY };
        escrever();
        desenhar();
    });
    const soltar = () => {
        arrasto = null;
        previa.classList.remove('arrastando');
    };
    previa.addEventListener('pointerup', soltar);
    previa.addEventListener('pointercancel', soltar);

    previa.addEventListener('wheel', (evento) => {
        if (!estado.carregada) return;
        evento.preventDefault();
        estado.zoom = limitar(estado.zoom * Math.exp(-evento.deltaY * 0.0015), ZOOM_MINIMO, ZOOM_MAXIMO);
        escrever();
        desenhar();
    }, { passive: false });

    new ResizeObserver(desenhar).observe(previa);
    deslizante.value = estado.zoom;
    carregar(campoImagem?.querySelector('[data-url-imagem]').value.trim());
}

// --- Campo que so vale para uma opcao de outro ------------------------------

// data-mostrar-quando="tipo=empresa": a empresa so aparece para usuario de
// empresa. Sem JavaScript o campo fica visivel, e o servidor decide igual.
document.querySelectorAll('[data-mostrar-quando]').forEach((bloco) => {
    const [nome, valor] = bloco.dataset.mostrarQuando.split('=');
    const campo = document.querySelector(`[name="${nome}"]`);
    if (!campo) return;

    const atualizar = () => {
        bloco.hidden = campo.value !== valor;
    };
    campo.addEventListener('change', atualizar);
    atualizar();
});

// --- Grafico do resumo ------------------------------------------------------

document.querySelectorAll('[data-grafico]').forEach(iniciarGrafico);

/**
 * Dica por coluna: passar o mouse (ou o dedo) mostra o dia com o valor de cada
 * forma e o total. Pelo teclado, o grafico e uma parada so de tabulacao, e as
 * setas percorrem as colunas. Os mesmos numeros estao na tabela abaixo dele -
 * a dica nunca e o unico caminho ate um valor.
 */
function iniciarGrafico(grafico) {
    const area = grafico.querySelector('[data-colunas]');
    const dica = grafico.querySelector('[data-dica]');
    const colunas = [...grafico.querySelectorAll('[data-coluna]')];
    if (!area || !dica || colunas.length === 0) return;

    let ativa = -1;

    const linha = (classeChave, valor, rotulo, extra) => {
        const item = document.createElement('div');
        item.className = `grafico-dica-linha${extra ? ` ${extra}` : ''}`;
        const chave = document.createElement('span');
        chave.className = `chave ${classeChave}`;
        const forte = document.createElement('strong');
        forte.textContent = valor;
        const nome = document.createElement('span');
        nome.textContent = rotulo;
        item.append(chave, forte, nome);
        return item;
    };

    function mostrar(indice) {
        if (ativa >= 0) colunas[ativa].classList.remove('ativa');
        ativa = indice;
        const coluna = colunas[indice];
        coluna.classList.add('ativa');

        const dados = JSON.parse(coluna.dataset.coluna);
        const titulo = document.createElement('div');
        titulo.className = 'grafico-dica-titulo';
        titulo.textContent = dados.titulo;
        dica.replaceChildren(
            titulo,
            ...dados.series.map(([classe, rotulo, valor]) => linha(classe, valor, rotulo)),
            linha('chave-vazia', dados.total, 'Total', 'grafico-dica-total'),
        );
        dica.hidden = false;

        // Ao lado da coluna, e nao em cima dela: o dado apontado fica a vista.
        // A direita quando cabe; senao, a esquerda. Nunca sai do grafico.
        const caixa = grafico.getBoundingClientRect();
        const alvo = coluna.getBoundingClientRect();
        const plot = area.getBoundingClientRect();
        const largura = dica.offsetWidth;
        const direita = alvo.right - caixa.left + 8;
        const esquerda = direita + largura <= caixa.width ? direita : alvo.left - caixa.left - largura - 8;
        dica.style.left = `${Math.min(Math.max(0, esquerda), caixa.width - largura)}px`;
        dica.style.top = `${plot.top - caixa.top}px`;
    }

    function esconder() {
        if (ativa >= 0) colunas[ativa].classList.remove('ativa');
        ativa = -1;
        dica.hidden = true;
    }

    colunas.forEach((coluna, indice) => {
        coluna.addEventListener('pointerenter', () => mostrar(indice));
    });
    // No toque o dedo sai logo depois de encostar: a dica fica ate tocar fora.
    area.addEventListener('pointerleave', (evento) => {
        if (evento.pointerType !== 'touch' && document.activeElement !== area) esconder();
    });
    document.addEventListener('pointerdown', (evento) => {
        if (ativa >= 0 && !grafico.contains(evento.target)) esconder();
    });

    // Pelo teclado comeca na coluna mais recente: e a que se procura primeiro.
    area.addEventListener('focus', () => mostrar(ativa >= 0 ? ativa : colunas.length - 1));
    area.addEventListener('blur', esconder);
    area.addEventListener('keydown', (evento) => {
        const atual = ativa >= 0 ? ativa : colunas.length - 1;
        const destino = {
            ArrowLeft: atual - 1,
            ArrowRight: atual + 1,
            Home: 0,
            End: colunas.length - 1,
        }[evento.key];

        if (evento.key === 'Escape') {
            esconder();
            return;
        }
        if (destino === undefined) return;
        evento.preventDefault();
        mostrar(Math.min(Math.max(0, destino), colunas.length - 1));
    });
}
