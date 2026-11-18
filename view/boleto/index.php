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
    $dadosboleto["data_documento"]     = $dataproc; // Data de emiss�o do Boleto
    $dadosboleto["data_processamento"] = $dataproc; // Data de processamento do boleto (opcional)
    $dadosboleto["valor_boleto"]       = $reg['valorvenc']; // Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
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
?>
  <div class='container cta' id='pagina'>
    <h1>Emissão de Boleto OnLine</h1>
    <?php
    if (isset ($_POST['op'])){
      $op = $_POST['op'];
    }
    if (!isset($_POST['op'])) {
?>
    <!--<p>Para retirar o boleto, entre em contato pelo telefone\WhatsApp: <a href="https://wa.me/551938661100" target="_blank">(19) 3866-1100</a></p>-->
       <br />Informe o CNPJ ou CPF do titular do cadastro na ABCS Informática e clique no botão "Listar Boletos":
      <br />
      <br />
      <form action="/boleto" method=POST>
        <input type=hidden name='op' value='l' /> CPF ou CNPJ:
        <input type=text onkeyup="somenteNumeros(this);" name="edtCnpjCpf" /> (somente números)
        <br />
        <br />
        <input class="btn btn-lg btn-info" type=submit value="Listar Boletos" />
      </form>
  </div>
  <?php
    } elseif ($op=='l') {
      $cnpjcpf=$_POST["edtCnpjCpf"];

      if (!validaCPF($cnpjcpf) && !validaCNPJ($cnpjcpf))
      {
        echo "<br /><br /><h1><font color=red>CNPJ/CPF inválido!</font></h1>";
      } else {
        if (trim($cnpjcpf)!='') {
           $idcon = mysqli_connect("186.233.16.211", "abcs_boleto", "BBLuPvK-~861", "abcs_boleto") or die( 'Erro ao conectar com o banco de dados! ' . db_error() );
          $idqry  = mysqli_query($idcon, "select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where cnpjcpfnum='$cnpjcpf'");
          if (mysqli_num_rows($idqry)>0) {
            echo "<br /><br />Clique no botão <button type='button' class='btn btn-dark'><i class='fa fa-barcode' aria-hidden='true'></i>Boleto</button> na frente da parcela para gerar o boleto correspondente:<br /><br />";
            echo "<table class='table table-responsive table-sm ' style='overflow-y:scroll;'>";
            echo "<thead class='thead-inverse'><th></th><th>Cliente</th><th>Nosso Número</th><th>Vencimento Original</th><th>Valor Original</th><th>Vencimento Atualizado</th><th>Valor Atualizado</th><th>Detalhes da Fatura</th></thead>";
            while ($reg = mysqli_fetch_array( $idqry)) {
              $hoje=date("Y-m-d");
              $anteontem =date("Y-m-d", time() - 172800);
              $class="";
              $vlroriginal = $reg['valorvenc'];
              $dataoriginal = $reg['datavenc'];
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
                $reg['datavenc']  =  date("d/m/Y");
              }
              $link="<a href='boleto/".$reg['nossonr']."' target='_blank' role='button' class='btn btn-dark'>";
              echo "<tr $class><td with=\"42\" >$link<i class='fa fa-barcode' aria-hidden='true'></i>Boleto</a>";
              echo "<td>$reg[nome]</td>";
              echo "<td>$reg[nossonr]</a></td>";
              echo "<td>";
              echo converter_data($dataoriginal );
              echo "</td>";
              echo "<td>R$" . number_format($vlroriginal,2) . "</td>";
              echo "<td>";
              echo converter_data($reg['datavenc'] );
              echo "</td>";
              echo "<td>R$" . number_format($reg['valorvenc'],2) . "</td>";
              echo "<td>".$reg['detalhe']."</td>";
              echo "</tr>";
            }
            echo "</table>";
            echo "<br /><br /><i>Obs: os boletos já quitados sairão da lista de parcelas em aberto em até 2 (dois) dias úteis após o pagamento</i>";
          } else {
            echo "<BR /><BR /><h1><font color=red>NENHUM BOLETO ENCONTRADO PARA O DOCUMENTO INFORMADO!</font></h1>";
          }
          mysqli_close($idcon);
        }
        else
          echo 'Favor informar o CNPJ ou CPF do titular do contrato de acesso � internet!';
      }
    }
  }
  ?>
    </div>
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