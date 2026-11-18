<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do      |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto BANCOOB/SICOOB: Marcelo de Souza              |
// | Ajuste de algumas rotinas: Anderson Nuernberg                        |
// +----------------------------------------------------------------------+

$codigobanco = "756";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"], 10, 0, "valor");
//agencia � sempre 4 digitos
$agencia = formata_numero($dadosboleto["agencia"], 4, 0);
//conta � sempre 8 digitos
$conta = formata_numero($dadosboleto["conta"], 8, 0);

$carteira = $dadosboleto["carteira"];

//Zeros: usado quando convenio de 7 digitos
$livre_zeros = '000000';
$modalidadecobranca = $dadosboleto["modalidade_cobranca"];
$numeroparcela = $dadosboleto["numero_parcela"];

$convenio = formata_numero($dadosboleto["convenio"], 7, 0);

//agencia e conta
$agencia_codigo = $agencia . " / " . $convenio;

// Nosso n�mero de at� 8 d�gitos - 2 digitos para o ano e outros 6 numeros sequencias por ano
// deve ser gerado no programa boleto_bancoob.php
$nossonumero = formata_numero($dadosboleto["nosso_numero"], 8, 0);
$campolivre = "$modalidadecobranca$convenio$nossonumero$numeroparcela";

$dv = modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$carteira$agencia$campolivre");
$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$carteira$agencia$campolivre";

$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

// FUN��ES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

function formata_numero($numero, $loop, $insert, $tipo = "geral")
{
    if ($tipo == "geral") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "valor") {
        /*
        retira as virgulas
        formata o numero
        preenche com zeros
         */
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "convenio") {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    return $numero;
}

function fbarcode($valor)
{

    $fino = 1;
    $largo = 3;
    $altura = 50;

    $barcodes[0] = "00110";
    $barcodes[1] = "10001";
    $barcodes[2] = "01001";
    $barcodes[3] = "11000";
    $barcodes[4] = "00101";
    $barcodes[5] = "10100";
    $barcodes[6] = "01100";
    $barcodes[7] = "00011";
    $barcodes[8] = "10010";
    $barcodes[9] = "01010";
    for ($f1 = 9; $f1 >= 0; $f1--) {
        for ($f2 = 9; $f2 >= 0; $f2--) {
            $f = ($f1 * 10) + $f2;
            $texto = "";
            for ($i = 1; $i < 6; $i++) {
                $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
            }
            $barcodes[$f] = $texto;
        }
    }

    //Desenho da barra

    //Guarda inicial
  $codbarras = '';
  $codbarras.='<img src="./img/p.png" width='.$fino.' height='.$altura.' border=0><img ';
	$codbarras.='src="./img/b.png" width='.$fino.' height='.$altura.' border=0><img ';
	$codbarras.='src="./img/p.png" width='.$fino.' height='.$altura.' border=0><img ';
	$codbarras.='src="./img/b.png" width='.$fino.' height='.$altura.' border=0><img ';
$texto = $valor;
    if ((strlen($texto) % 2) != 0) {
        $texto = "0" . $texto;
    }

    // Draw dos dados
    while (strlen($texto) > 0) {
        $i = round(esquerda($texto, 2));
        $texto = direita($texto, strlen($texto) - 2);
        $f = $barcodes[$i];
        for ($i = 1; $i < 11; $i += 2) {
            if (substr($f, ($i - 1), 1) == "0") {
                $f1 = $fino;
            } else {
                $f1 = $largo;
            }
		$codbarras.='src="./img/p.png" width='.$f1.' height='.$altura.' border=0><img ';
if (substr($f, $i, 1) == "0") {
                $f2 = $fino;
            } else {
                $f2 = $largo;
            }
		$codbarras.='src="./img/b.png" width='.$f2.' height='.$altura.' border=0><img ';
}
    }

    // Draw guarda final
  $codbarras.='src="./img/p.png" width='.$largo.' height='.$altura.' border=0><img ';
	$codbarras.='src="./img/b.png" width='.$fino.' height='.$altura.' border=0><img ';
	$codbarras.='src="./img/p.png" width="1px" height='.$altura.' border=0>';
	return $codbarras;
} //Fim da fun��o

function esquerda($entra, $comp)
{
    return substr($entra, 0, $comp);
}

function direita($entra, $comp)
{
    return substr($entra, strlen($entra) - $comp, $comp);
}


function _dateToDays($year, $month, $day)
{
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century--;
        }
    }
    return (floor((146097 * $century) / 4) +
        floor((1461 * $year) / 4) +
        floor((153 * $month + 2) / 5) +
        $day + 1721119);
}

/*
#################################################
FUN��O DO M�DULO 10 RETIRADA DO PHPBOLETO

ESTA FUN��O PEGA O D�GITO VERIFICADOR DO PRIMEIRO, SEGUNDO
E TERCEIRO CAMPOS DA LINHA DIGIT�VEL
#################################################
 */
function modulo_10($num)
{
    $numtotal10 = 0;
    $fator = 2;

    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
        $parcial10[$i] = $numeros[$i] * $fator;
        $numtotal10 .= $parcial10[$i];
        if ($fator == 2) {
            $fator = 1;
        } else {
            $fator = 2;
        }
    }

    $soma = 0;
    for ($i = strlen($numtotal10); $i > 0; $i--) {
        $numeros[$i] = substr($numtotal10, $i - 1, 1);
        $soma += $numeros[$i];
    }
    $resto = $soma % 10;
    $digito = 10 - $resto;
    if ($resto == 0) {
        $digito = 0;
    }

    return $digito;
}



function geraCodigoBanco($numero)
{
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo_11($parte1);
    return $parte1 . "-" . $parte2;
}


//corrigido
function fator_vencimento($data)
{
    $data_vencimento = DateTime::createFromFormat('d/m/Y', (string)$data);
    if ($data_vencimento === false) {
        return 0; // data invalida: evita TypeError no PHP 8 (diff sobre false)
    }
    $data_base = new DateTime('1997-10-07');
    if ($data_vencimento < new DateTime('2025-02-22')) {
        return $data_base->diff($data_vencimento)->days;
    } else {
        // Novo fator de vencimento (resetado para 1000 a partir de 21/02/2025)
        $data_nova_base = new DateTime('2025-02-22');
        return 1000 + $data_nova_base->diff($data_vencimento)->days;
    }
}

function modulo_11($num, $base = 9, $r = 0)
{
    $soma = 0;
    $fator = 2;
    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
        $parcial[$i] = $numeros[$i] * $fator;
        $soma += $parcial[$i];
        if ($fator == $base) {
            $fator = 1;
        }
        $fator++;
    }
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;

        //corrigido
        if ($digito == 10) {
            $digito = "X";
        }

        if (strlen($num) == "43") {
            //então estamos checando a linha digitável
            if ($digito == "0" or $digito == "X" or $digito > 9) {
                $digito = 1;
            }
        }
        return $digito;
    } elseif ($r == 1) {
        $resto = $soma % 11;
        return $resto;
    }
}

function monta_linha_digitavel($linha)
{
   

    $p1 = substr($linha, 0, 4);
    $p2 = substr($linha, 19, 5);
    $p3 = modulo_10("$p1$p2");
    $p4 = "$p1$p2$p3";
    $p5 = substr($p4, 0, 5);
    $p6 = substr($p4, 5);
    $campo1 = "$p5.$p6";
   

    $p1 = substr($linha, 24, 10);
    $p2 = modulo_10($p1);
    $p3 = "$p1$p2";
    $p4 = substr($p3, 0, 5);
    $p5 = substr($p3, 5);
    $campo2 = "$p4.$p5";
   

    $p1 = substr($linha, 34, 10);
    $p2 = modulo_10($p1);
    $p3 = "$p1$p2";
    $p4 = substr($p3, 0, 5);
    $p5 = substr($p3, 5);
    $campo3 = "$p4.$p5";
   

    $campo4 = substr($linha, 4, 1);
   

    $campo5 = substr($linha, 5, 14);
   

    return "$campo1 $campo2 $campo3 $campo4 $campo5";
}

?>
