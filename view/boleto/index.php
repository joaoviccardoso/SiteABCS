<?php
  $cooperativa = '3122'; //4 digitos
  $cedente  = '0164623'; //7 digitos
  function calcdv($cooperativa,$cedente,$nossonr) {
    $cedente = str_pad($cedente,10,"0",STR_PAD_LEFT);
    $nossonr = str_pad($nossonr,7,"0",STR_PAD_LEFT);
    $nr11 = substr($cooperativa,0,1)*3;
    $nr12 = substr($cooperativa,1,1)*1;
    $nr13 = substr($cooperativa,2,1)*9;
    $nr14 = substr($cooperativa,3,1)*7;
    $nr21 = substr($cedente,0,1)*3;
    $nr22 = substr($cedente,1,1)*1;
    $nr23 = substr($cedente,2,1)*9;
    $nr24 = substr($cedente,3,1)*7;
    $nr25 = substr($cedente,4,1)*3;
    $nr26 = substr($cedente,5,1)*1;
    $nr27 = substr($cedente,6,1)*9;
    $nr28 = substr($cedente,7,1)*7;
    $nr29 = substr($cedente,8,1)*3;
    $nr20 = substr($cedente,9,1)*1;
    $nr31 = substr($nossonr,0,1)*9;
    $nr32 = substr($nossonr,1,1)*7;
    $nr33 = substr($nossonr,2,1)*3;
    $nr34 = substr($nossonr,3,1)*1;
    $nr35 = substr($nossonr,4,1)*9;
    $nr36 = substr($nossonr,5,1)*7;
    $nr37 = substr($nossonr,6,1)*3;
    $dv  = $nr11 + $nr12 + $nr13 + $nr14 + $nr21 + $nr22 + $nr23 + $nr24 + $nr25 + $nr26 + $nr27 + $nr28 + $nr29 + $nr20 + $nr31 + $nr32 + $nr33 + $nr34 + $nr35 + $nr36 + $nr37;
    $dv  = $dv % 11;
    if ($dv>1)
      $dv = 11-$dv;
    else
      $dv = 0;
    return $dv;
  }
   function validaCPF($cpf) {
      $soma = 0;
      if (strlen($cpf) <> 11)
         return false;
      else
         return true;
   }
   function validaCNPJ($cnpj) {

      if (strlen($cnpj) <> 14)
         return false;
      else
         return true;
   }
  function converter_data($data) {
    $dataaux = explode('-',$data );
    $dataaux = array_reverse( $dataaux );
    return( implode( '/', $dataaux ) );
   }
  function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
  }
  if (isset($_GET["gerar"])) {
    $codigo=$_GET["codbol"];
     $idcon = mysqli_connect("186.233.16.211", "abcs_boleto", "BBLuPvK-~861", "abcs_boleto") or die( 'Erro ao conectar com o banco de dados! ' . db_error() );
    $idqry  = mysqli_query($idcon,"select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where codigo=$codigo");
    $reg = mysqli_fetch_array( $idqry, MYSQL_ASSOC );
    mysqli_close($idcon);
    $dias_de_prazo_para_pagamento = 0;
    $reg["juros"] = $reg["juros"]/100;
    $reg["multa"] = $reg["multa"]/100;
    $taxa_boleto  = 0;
    $valormulta   = number_format(round($reg["valorvenc"] * $reg["multa"], 4),2,'.','');
    $valorjuros   = number_format(round($reg["valorvenc"] * $reg["juros"], 4),2,'.','');
    $hoje=date("Y-m-d");
    if ($hoje>$reg["datavenc"]) {
      $reg["valorvenc"] = $reg["valorvenc"] + $valormulta + ($valorjuros * $reg[atraso]);
      $reg["datavenc"]  = $hoje;
    }
    $reg['valorvenc']             = str_replace(",", ".",$reg['valorvenc']);
    $reg['valorvenc']             = number_format($reg['valorvenc'] + $taxa_boleto, 2, ',', '');
    $dadosboleto["nosso_numero"]       = $reg["nossonr"].calcdv($cooperativa,$cedente,$reg['nossonr']); // nosso numero devera ter 7 digitos no total, preenchido com zeros a esquerda
    $dadosboleto["numero_documento"]   = $reg['pedido'];	      // Num do pedido ou do documento
    $dadosboleto["data_vencimento"]    = converter_data( $reg['datavenc'] );    // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    if (date('d/m/Y')>$reg["datavenc"]) {
      $dataproc = $reg["datavenc"];
    } else {
      $dataproc = date('d/m/Y');
    }
    $dadosboleto["data_documento"]     = $dataproc; // Data de emissão do Boleto
    $dadosboleto["data_processamento"] = $dataproc; // Data de processamento do boleto (opcional)
    $dadosboleto["valor_boleto"]       = $reg['valorvenc']; // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
    $dadosboleto["sacado"]    = $reg['nome'];
    $dadosboleto["endereco1"] = "$reg[endereco], $reg[numero] - $reg[complemento] - $reg[bairro]";
    $dadosboleto["endereco2"] = "$reg[cidade] - $reg[estado] -  $reg[cep]";
    $dadosboleto["demonstrativo1"] = "";
    if ($hoje<$reg["datavenc"])
      $dadosboleto["instrucoes1"] = "- Após o vencimento cobrar multa de R$$valormulta e juros de R$$valorjuros ao dia";
    else
      $dadosboleto["instrucoes1"] = "- Após o vencimento cobrar juros de R$$valorjuros ao dia";
    $dadosboleto["instrucoes2"] = "- Em caso de dúvidas entre em contato conosco: nfe@abcsinformatica.com.br ou pelo telefone 19 3866-1100";
    $dadosboleto["instrucoes3"] = "";
    $dadosboleto["instrucoes4"] = "- www.abcsinformatica.com.br";
    $dadosboleto["quantidade"]     = "";
    $dadosboleto["valor_unitario"] = "";
    $dadosboleto["aceite"]         = "N";
    $dadosboleto["especie"]        = "R$";
    $dadosboleto["especie_doc"]    = "DM";
    $dadosboleto["modalidade_cobranca"] = "02";
    $dadosboleto["numero_parcela"]      = "001";
    $dadosboleto["agencia"] = $cooperativa;    // Num da agencia, sem digito
    $dadosboleto["conta"]   = $cedente; // Num da conta, sem digito
    $dadosboleto["convenio"] = $cedente; // Num do convênio - REGRA: No maximo 7 digitos
    $dadosboleto["carteira"] = "1";
    $dadosboleto["identificacao"] = "ABCS Informática";
    $dadosboleto["cpf_cnpj"]      = "00.246.242/0001-60";
    $dadosboleto["endereco"]      = "Rua das Angelicas, 622 - Centro";
    $dadosboleto["cidade_uf"]     = "Conchal - SP";
    $dadosboleto["cedente"]       = "Cesar A Bonini";
    include("include/funcoes_bancoob.php");
    include("include/layout_bancoob.php");
  } else {

    /* ---------- lógica da listagem (igual à original) ---------- */
    $op = isset($_POST['op']) ? $_POST['op'] : '';
    $cnpjcpfDigitado = isset($_POST['edtCnpjCpf']) ? h($_POST['edtCnpjCpf']) : '';
    $mensagemErro = '';
    $linhas = array();

    if ($op == 'l') {
      $cnpjcpf = $_POST["edtCnpjCpf"];
      if (!validaCPF($cnpjcpf) && !validaCNPJ($cnpjcpf)) {
        $mensagemErro = 'CNPJ/CPF inválido!';
      } else {
        if (trim($cnpjcpf) != '') {
          $idcon = mysqli_connect("186.233.16.211", "abcs_boleto", "BBLuPvK-~861", "abcs_boleto") or die( 'Erro ao conectar com o banco de dados! ' . mysqli_connect_error() );
          $idqry = mysqli_query($idcon, "select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where cnpjcpfnum='$cnpjcpf'");
          if (mysqli_num_rows($idqry) > 0) {
            while ($reg = mysqli_fetch_array($idqry)) {
              $hoje = date("Y-m-d");
              $anteontem = date("Y-m-d", time() - 172800);
              $vencido = false;
              $vlroriginal = $reg['valorvenc'];
              $dataoriginal = $reg['datavenc'];
              $agora = mktime(0,0,0,date("m"),date("d"),date("Y"));
              $dataAtualizada = converter_data($reg['datavenc']);
              if ($hoje > $reg["datavenc"]) {
                $vencido = true;
                $reg["juros"] = $reg["juros"]/100;
                $reg["multa"] = $reg["multa"]/100;
                if (date("w", $agora) == 1) {
                  if ($anteontem > $reg["datavenc"])
                    $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
                } else {
                  $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
                }
                $dataAtualizada = date("d/m/Y");
              }
              $linhas[] = array(
                'vencido'        => $vencido,
                'nossonr'        => $reg['nossonr'],
                'nome'           => $reg['nome'],
                'dataoriginal'   => converter_data($dataoriginal),
                'vlroriginal'    => number_format($vlroriginal, 2),
                'dataatualizada' => $dataAtualizada,
                'vlratualizado'  => number_format($reg['valorvenc'], 2),
                'detalhe'        => $reg['detalhe'],
              );
            }
          } else {
            $mensagemErro = 'NENHUM BOLETO ENCONTRADO PARA O DOCUMENTO INFORMADO!';
          }
          mysqli_close($idcon);
        } else {
          $mensagemErro = 'Favor informar o CNPJ ou CPF do titular do contrato.';
        }
      }
    }
?>
<section class="servico" id="pagina">
  <div class="servico__grid">
    <div class="servico__conteudo">
      <p class="servico__eyebrow">Soluções corporativas</p>
      <h1>Emissão de Boleto OnLine</h1>
      <p class="servico__texto">Informe o CNPJ ou CPF do titular do cadastro na ABCS Informática e clique no botão "Listar Boletos".</p>

      <form class="servico__form" action="/boleto" method="POST">
        <input type="hidden" name="op" value="l" />
        <label for="edtCnpjCpf">CPF ou CNPJ (somente números):</label>
        <input type="text" name="edtCnpjCpf" id="edtCnpjCpf" inputmode="numeric" placeholder="Somente números" onkeyup="somenteNumeros(this);" value="<?php echo $cnpjcpfDigitado; ?>" />
        <button class="servico__btn" type="submit">Listar Boletos</button>
      </form>

      <?php if ($mensagemErro != '') { ?>
        <p class="servico__erro" role="alert"><?php echo h($mensagemErro); ?></p>
      <?php } ?>
    </div>

    <div class="servico__foto">
      <img src="/img/boleto-hero.jpg" alt="Pessoa conferindo um boleto com notebook e calculadora" />
    </div>
  </div>

  <?php if (count($linhas) > 0) { ?>
  <div class="servico__lista">
    <p>Clique no botão <strong>Boleto</strong> na frente da parcela para gerar o boleto correspondente:</p>
    <div class="servico__tabela">
      <table class="listabols">
        <thead>
          <tr>
            <th></th>
            <th align="left">Cliente</th>
            <th>Nosso Número</th>
            <th>Vencimento Original</th>
            <th align="right">Valor Original</th>
            <th>Vencimento Atualizado</th>
            <th align="right">Valor Atualizado</th>
            <th align="left">Detalhes da Fatura</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($linhas as $l) { ?>
          <tr<?php echo $l['vencido'] ? ' class="bg-danger"' : ''; ?>>
            <td>
              <a href="/boleto/<?php echo h($l['nossonr']); ?>" target="_blank" role="button" class="servico__btn servico__btn--sm">
                <i class="fa fa-barcode" aria-hidden="true"></i> Boleto
              </a>
            </td>
            <td><?php echo h($l['nome']); ?></td>
            <td align="center"><?php echo h($l['nossonr']); ?></td>
            <td align="center"><?php echo h($l['dataoriginal']); ?></td>
            <td align="right">R$<?php echo h($l['vlroriginal']); ?></td>
            <td align="center"><?php echo h($l['dataatualizada']); ?></td>
            <td align="right">R$<?php echo h($l['vlratualizado']); ?></td>
            <td><?php echo h($l['detalhe']); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <p class="servico__nota"><em>Obs: os boletos já quitados sairão da lista de parcelas em aberto em até 2 (dois) dias úteis após o pagamento</em></p>
  </div>
  <?php } ?>
</section>

<script>
  function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
      campo.value = "";
    }
  }
</script>
<?php
  }
?>