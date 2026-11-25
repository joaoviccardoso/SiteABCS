// Faz as perguntas abrirem e fecharem quando clicadas.

// 1. Pega todos os botões de pergunta da página
var botoes = document.getElementsByClassName("accordion");

// 2. Para cada botão, define o que acontece ao clicar
for (var i = 0; i < botoes.length; i++) {
    botoes[i].onclick = function () {

        // "this" é o botão clicado. Marca/desmarca como ativo
        // (o CSS usa isso para girar a setinha)
        this.classList.toggle("active");

        // A resposta é o elemento logo depois do botão
        var resposta = this.nextElementSibling;

        if (resposta.style.maxHeight) {
            // Já estava aberta: fecha
            resposta.style.maxHeight = null;
        } else {
            // Estava fechada: abre na altura do conteúdo
            resposta.style.maxHeight = resposta.scrollHeight + "px";
        }
    };
}