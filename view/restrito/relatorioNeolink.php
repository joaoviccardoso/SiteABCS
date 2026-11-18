<div class='container' id='pagina'>
  <br />
  <form action='/restrito/relatorioNeolink' method='POST'>
    <input name='data' id='data' type='date'>
    <select name='idpdv' id='idpdv'>
      <option value=''></option>
      <?php
        for ($j = 0; $j < $i; $j++) {
            echo ('<option value=\'' . $pdvs[$j] . '\'>' . $pdvs[$j] . '</option> ');
        }
      ?>
    </select>
    <input type='submit' class='btn btn-primary' value='Buscar'></a>
    <a href='/restrito/pdfRelatorio/<?php echo $data ?>/<?php echo $idpdv ?>' target='_blank' class='btn btn-primary'>Exportar em PDF</a>
  </form>
  <br /><br /><br />
  <?php echo $this->pagamentostable($res); ?>
</div>