<div id='pagina'>
  <h1>Enviar boletos por e-mail</h1>
  <a class='black' href='./'>
    <p> Para voltar clique aqui</p>
  </a>
  <form action='enviaremail.php' method='POST'>
    <?php
  while($reg = mysqli_fetch_array( $idqry)){
    $this->mostrarBoleto($reg);  
  }
?>
      <input type='submit' value='Enviar E-mails'></input>
</div>