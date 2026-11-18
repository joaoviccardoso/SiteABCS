<div class='container' id='pagina'>
    <h1>
        <font class='brand black'>ABCS</font>
        <font class='subbrand mdfe'>MDFe</font>
    </h1>

    <button class="accordion">Como adquiro o ABCS MDFe?</button>
    <div class="panel">
        <p>Basta entrar em contato com a ABCS e um de nós irá te retornar. Você pode fazer isso clicando
            <a class='text-primary'
                href='../contato/Quero o ABCS MDFe'>aqui</a> ou ligando no telefone (19) 3866 1100</p>
    </div>

    <button class="accordion">Meu ABCS MDFe está me pedindo uma senha, como eu consigo ela?</button>
    <div class="panel">
        <p>A senha no ABCS MDFe é uma forma de garantir sua autenticidade e sua segurança. Você pode obter a senha clicando
            <a class='text-primary' href='./../senha'>aqui</a> e digitando o número de série de seu sistema, que estará na tela que pede sua senha.</p>
    </div>

    <button class="accordion">Não recebi meu boleto, como eu faço para emití-lo</button>
    <div class="panel">
        <p>O seu boleto sempre estará disponível on-line. Você pode emitir seu boleto clicando
            <a class='text-primary' href='./../boleto'>aqui</a> e digitando o seu CPF ou CNPJ.</p>
    </div>


    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            }
        }
    </script>
    <br/>
    <div class='container text-center'>
        <h3>
            <a class='btn btn-primary' href='../contato/Dúvidas com o ABCS MDFe'>Não achei minha dúvida</a>
        </h3>
    </div>
</div>