<div class='container' id='pagina'>
    <h1>Adicionar arquivo ao sistema</h1>
    <a class='black' href='./'>
        <p> Para voltar clique aqui</p>
    </a>
    <div class='col-md-12'>
        <form action='./enviarArquivo' method="post" enctype="multipart/form-data" name="cadastro">
            Arquivo:
            <br />
            <input type="file" name="arquivo" class="form-control" />
            <br />
            <br />

            <input type="submit" class='btn btn-info' name="cadastrar" value="Enviar Arquivo" class="form-control" />
        </form>
    </div>
</div>