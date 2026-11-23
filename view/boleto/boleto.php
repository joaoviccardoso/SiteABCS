<?php
header('Content-Type: text/html; charset=utf-8');
  $cooperativa = '3122'; //4 digitos
  $cedente  = '0164623'; //7 digitos
  require_once './lib/dompdf/autoload.inc.php';
  use Dompdf\Dompdf;
  use Dompdf\Options;

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
  $pagina = explode( '/', $_SERVER['REQUEST_URI']);
  if (isset($pagina[2])) {
    $codigo=$pagina[2];
     $idcon = mysqli_connect("186.233.16.211", "abcs_boleto", "BBLuPvK-~861", "abcs_boleto") or die( 'Erro ao conectar com o banco de dados! ' . db_error() );
    $idqry  = mysqli_query($idcon,"select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where nossonr=$codigo");
    if ($reg = mysqli_fetch_array( $idqry )){
      mysqli_close($idcon);
      $dias_de_prazo_para_pagamento = 0;
      $reg["juros"] = $reg["juros"]/100;
      $reg["multa"] = $reg["multa"]/100;
      $taxa_boleto  = 0;
      $valormulta   = number_format(round($reg["valorvenc"] * $reg["multa"], 4),2,'.','');
      $valorjuros   = number_format(round($reg["valorvenc"] * $reg["juros"], 4),2,'.','');
      $hoje=date("Y-m-d");
      $anteontem =date("Y-m-d", time() - 172800);
      $agora =  mktime(0,0,0,date("m"),date("d"),date("Y"));
      if ($hoje>$reg["datavenc"]) {
        if(date("w",  $agora) == 1){
          if(($anteontem>$reg["datavenc"])){
              $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
            $reg["datavenc"]  = $hoje;
          }
        }
        else{
          $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
          $reg["datavenc"]  = $hoje;
        }
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
      $dadosboleto["demonstrativo2"] = "";
      $dadosboleto["demonstrativo3"] = "";
      if ($hoje<$reg["datavenc"])
        $dadosboleto["instrucoes1"] = "- Após o vencimento cobrar multa de R$$valormulta e juros de R$$valorjuros ao dia";
      else
        $dadosboleto["instrucoes1"] = "Após o vencimento cobrar juros de R$$valorjuros ao dia";
      $dadosboleto["instrucoes2"] = "Em caso de dúvidas entre em contato conosco: nfe@abcsinformatica.com.br ou pelo telefone 19 3866-1100";
      $dadosboleto["instrucoes3"] = "www.abcsinformatica.com.br ";
      $dadosboleto["instrucoes4"] = "Detalhes da fatura - ".$reg['detalhe'];
      $dadosboleto["quantidade"]     = "";
      $dadosboleto["valor_unitario"] = "";
      $dadosboleto["aceite"]         = "N";
      $dadosboleto["especie"]        = "R$";
      $dadosboleto["especie_doc"]    = "DM";
      $dadosboleto["modalidade_cobranca"] = "01";
      $dadosboleto["numero_parcela"]      = "001";
      $dadosboleto["agencia"] = $cooperativa;    // Num da agencia, sem digito
      $dadosboleto["conta"]   = $cedente; // Num da conta, sem digito
      $dadosboleto["convenio"] = $cedente; // Num do convênio - REGRA: No maximo 7 digitos
      $dadosboleto["carteira"] = "1";
      $dadosboleto["identificacao"] = "ABCS Informática";
      $dadosboleto["cpf_cnpj"]      = "00.246.242/0001-60";
      $dadosboleto["endereco"]      = "Rua das Angelicas, 622 - Centro";
      $dadosboleto["cidade_uf"]     = "Conchal - SP";
      $dadosboleto["cedente"]       = "ABCS INFORMATICA LTDA";

      include("./view/boleto/include/funcoes_bancoob.php");
      include("./view/boleto/include/layout_bancoob.php");
      //echo gerarBoleto($dadosboleto);

    $options = new Options();
    $options->setChroot(realpath('.')); // libera a leitura de ./img/ (logo e barras do codigo) no dompdf 3.x
    $dompdf = new Dompdf($options);
    $dompdf->setBasePath(realpath('.'));
    $dompdf->loadHtml(gerarBoleto($dadosboleto));
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream(
        "boleto.pdf",
        array(
            "Attachment" => false
        )
    );


    }
    else{
      echo '<meta http-equiv="refresh" content="0;url=/500"/>' ;
    }
  } else {
    $op = isset($_POST['op']) ? $_POST['op'] : '';
    $cnpjcpfDigitado = isset($_POST['edtCnpjCpf']) ? htmlspecialchars($_POST['edtCnpjCpf'], ENT_QUOTES, 'UTF-8') : '';
?>
<!-- ===================== NOVO VISUAL (só HTML/CSS mudou) ===================== -->
<section class="servico" id="pagina1">
  <div class="servico__grid">
    <div class="servico__conteudo">
      <p class="servico__eyebrow">Soluções corporativas</p>
      <h1>Emissão de Boleto OnLine</h1>
      <p class="servico__texto">Informe o CNPJ ou CPF do titular do cadastro na ABCS Informática e clique no botão "Listar Boletos".</p>

      <form class="servico__form" action="index.php" method="POST">
        <input type="hidden" name="op" value="l" />
        <label for="edtCnpjCpf">CPF ou CNPJ (somente números):</label>
        <input type="text" name="edtCnpjCpf" id="edtCnpjCpf" inputmode="numeric" placeholder="Somente números" value="<?php echo $cnpjcpfDigitado; ?>" />
        <button class="servico__btn" type="submit">Listar Boletos</button>
      </form>

      <div class="servico__resultado">
<?php
    if ($op=='l') {
      $cnpjcpf=$_POST["edtCnpjCpf"];

      if (!validaCPF($cnpjcpf) && !validaCNPJ($cnpjcpf))
      {
        echo "<p class=\"servico__erro\">CNPJ/CPF inválido!</p>";
      } else {
        if (trim($cnpjcpf)!='') {
           $idcon = mysqli_connect("186.233.16.211", "abcs_boleto", "BBLuPvK-~861", "abcs_boleto") or die( 'Erro ao conectar com o banco de dados! ' . db_error() );
          $idqry  = mysqli_query($idcon, "select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where cnpjcpfnum='$cnpjcpf'");
          if (mysqli_num_rows($idqry)>0) {
            echo "<p>Clique no botão <img src=\"boleto.gif\" alt=\"boleto\" /> na frente da parcela para gerar o boleto correspondente:</p>";
            echo "<table class=\"listabols\">";
            echo "<tr><th align=\"left\">Cliente</th><th align=\"center\">Nosso Número</th><th align=\"center\">Vencimento</th><th align=\"right\">Valor</th><th></th></tr>";
            while ($reg = mysqli_fetch_array( $idqry, MYSQLI_ASSOC )) {
              $hoje=date("Y-m-d");
              $anteontem =date("Y-m-d", time() - 172800);
              $class="";
              $agora =  mktime(0,0,0,date("m"),date("d"),date("Y"));
              if ($hoje>$reg["datavenc"]) {
                $class = "class=\"bg-danger\"";
                $reg["juros"] = $reg["juros"]/100;
                $reg["multa"] = $reg["multa"]/100;
                if(date("w",  $agora) == 1){
                  if(($anteontem>$reg["datavenc"]))
                    $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
                }
                else{
                    $reg["valorvenc"] = round($reg["valorvenc"] + ($reg["valorvenc"] * $reg["multa"]) + ($reg["valorvenc"] * $reg["atraso"] * $reg["juros"]), 2);
                }
              }
              $link="<a href=\"index.php?gerar=s&codbol=$reg[codigo]\" target=new>";
              echo "<tr $class><td>$reg[nome]</td>";
              echo "<td align=\"center\">$reg[nossonr]</td>";
              echo "<td align=\"center\">";
              echo converter_data($reg['datavenc'] );
              echo "</td>";
              echo "<td align=\"right\">" . number_format($reg['valorvenc'],2) . "</td>";
              echo "<td width=\"42\" align=\"center\">$link<img src=\"boleto.gif\" border=\"0\" /></a>&nbsp;&nbsp;<a class=\"tooltip\" href=\"#\"><img src=\"detalhes.gif\" border=\"0\" />";
              echo "<span><b>Detalhes da Fatura:</b><br />$reg[detalhe]</span>";
              echo "</a></td></tr>";
            }
            echo "</table>";
            echo "<p><em>Obs: os boletos já quitados sairão da lista de parcelas em aberto em até 2 (dois) dias úteis após o pagamento</em></p>";
          } else {
            echo "<p class=\"servico__erro\">NENHUM BOLETO ENCONTRADO PARA O DOCUMENTO INFORMADO!</p>";
          }
          mysqli_close($idcon);
        }
        else
          echo '<p class="servico__erro">Favor informar o CNPJ ou CPF do titular do contrato de acesso à internet!</p>';
      }
    }
?>
      </div>
    </div>

    <div class="servico__foto">
      <img src="/img/boleto-hero.jpg" alt="Pessoa conferindo um boleto com notebook e calculadora" />
    </div>
  </div>
</section>
<?php
  }
?>