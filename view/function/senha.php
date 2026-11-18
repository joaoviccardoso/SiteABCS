<div class='container cta' id='pagina'>
  <h1>Senha do seu sistema
    <font class='brand'>ABCS</font>
  </h1>
  <div class="wrap">
    <div class="form-group">
      <form method='POST' action='\senha'>
        <p>Digite seu serial:</p>
        <input style='text-transform: uppercase;' type='text' name='serial' id='serial' value='<?php echo $serial ?>' />
        <input class='btn btn-info' type='submit' value='Gerar Senha' />
      </form>
    </div>
    <?php
      if ($_POST) {
          echo $this->retornoSite($obj);
      }
    ?>
  </div>
</div>