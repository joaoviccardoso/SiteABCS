<div class='container' id='pagina'>
    <h1>Emails Enviados</h1>
    <a class='black' href='./'>
        <p> Para voltar clique aqui</p>
    </a>
    <table class='table '>
        <thead>
            <td>ID</td>
            <td>Enviado</td>
            <td>Recebido</td>
            <td>Destinatário</td>
            <td>Remetente</td>
            <td>Assunto</td>
            <td>Mensagem</td>
        </thead>
        <?php
            while($email = mysqli_fetch_array($res)){
                echo $this->emailTD($email);
            }
        ?>
    </table>
</div>