<?php
@require_once './model/layoutModel.php';
@require_once './model/emailModel.php';
@require_once './model/apiModel.php';

class functionController
{
    public function senha()
    {
        $layout = new layoutModel('senha', 'senha, senha para sistema, abcs, sistemas, sistemas para empresas', '| Senha');

        if ($_POST) {
            $serial = $_POST['serial'];
            $serial = trim($serial);

            $cabecalho = array(
                'Content-Type: application/json',
            );

        if ((strcasecmp($_SERVER['REMOTE_ADDR'], '186.233.20.174') == 0) ) {

            $url = 'http://192.168.10.89/abcs/licenca?Auth=7N2lHfcIq1eEkkIzThnLuTNDOZtlLho2eHTPWsxvUD5o48zzl3kTxfomVO1q1Yj3a6QG7eQHNXmdmyi3TSktkLiBau0OPMjkJjr1adXo9044CQH2PnI56T37Q1xNnGp1&Serial=' . $serial;

            $req = 'http://192.168.10.89';

        } else {

            $url = 'http://186.233.20.174/abcs/licenca?Auth=7N2lHfcIq1eEkkIzThnLuTNDOZtlLho2eHTPWsxvUD5o48zzl3kTxfomVO1q1Yj3a6QG7eQHNXmdmyi3TSktkLiBau0OPMjkJjr1adXo9044CQH2PnI56T37Q1xNnGp1&Serial=' . $serial;

            $req = 'http://186.233.20.174';

        }

        $Comunicacao = new Comunicacao;

        $resposta = $Comunicacao->enviaConteudoParaAPI($cabecalho, '', $url,'GET');

            $obj = json_decode($resposta);
        }

        include "view/function/senha.php";
        unset($layout);
    }

    public function boleto($boleto)
    {

        if (isset($boleto) && ($boleto != '')) { 
            include "view/boleto/boleto.php";
        } else {
            $layout = new layoutModel('boleto', 'boleto, abcs, sistemas, sistemas para empresas', '| Emissão de boleto');
            include "view/boleto/index.php";
            //include "view/home/manutencao.php";
            unset($layout);
        }
    }

    public function contato()
    {
        $layout = new layoutModel('contato', 'contato, fale conosco, abcs, sistemas, sistemas para empresas', '| Fale Conosco');
        include "view/function/contato.php";
        unset($layout);
    }
    public function sitemap()
    {
        $xml = require "view/uteis/sitemap.xml";
        echo $xml;
    }
    public function contatoRealizado()
    {
        if ($_POST) {
            $remetente = $_POST["email"];
            $nome_remetente = $_POST["nome"];
            $assunto = $_POST["assunto"];
            $telefone = $_POST["telefone"];
            $endereco = $_POST["endereco"];
            $cidade = $_POST["cidade"];
            $estado = $_POST["estado"];
            $cep = $_POST["cep"];
            $mensagem = $_POST["mensagem"];

            $texto = '';
            $texto .= "<p>" . $mensagem . "</p>";
            $texto .= "<h4>" . $nome_remetente . "</h4>";
            $texto .= "<p>Telefone:" . $telefone . "</p>";
            $texto .= "<p>Email:" . $remetente . "</p>";
            $texto .= "<p>Endereço:" . $endereco . "-" . $cidade . "-" . $estado . "-" . $cep . "</p>";

            $email = new emailModel("suporte@abcsinformatica.com.br", "Suporte", 'Contato via site | ' . $assunto, $texto, $remetente, $nome_remetente);

            if ($email == true) {
                $this->envioOK();
            } else {
                $this->erroNoEnvio();
            }
        } else {
            $this->erroNoEnvio();
        }
    }
    private function envioOK()
    {
        $layout = new layoutModel('contato', 'contato, fale conosco, abcs, sistemas, sistemas para empresas', '| Mensagem Enviada com Sucesso');
        include "view/function/envioOK.php";
        unset($layout);
    }
    private function erroNoEnvio()
    {
        $layout = new layoutModel('contato', 'contato, fale conosco, abcs, sistemas, sistemas para empresas', '| Erro no Envio');
        include "view/function/erroNoEnvio.php";
        unset($layout);
    }
    public function teamviewer()
    {
        header("location:https://898.tv/abcsinformatica");
    }
    public function mail()
    {
        header("location:https://webmail.neolink.com.br/");
    }
    public function assunto()
    {
        $pagina = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($pagina[2])) {
            return 'value = "' . urldecode($pagina[2]) . '"';
        } else {
            return '';
        }
    }
    public function download($arquivo)
    {
        if (isset($arquivo) && file_exists($arquivo)) {
            switch (strtolower(substr(strrchr(basename($arquivo), "."), 1))) {
                case "pdf":$tipo = "application/pdf";
                    break;
                case "exe":$tipo = "application/octet-stream";
                    break;
                case "zip":$tipo = "application/zip";
                    break;
                case "doc":$tipo = "application/msword";
                    break;
                case "xls":$tipo = "application/vnd.ms-excel";
                    break;
                case "ppt":$tipo = "application/vnd.ms-powerpoint";
                    break;
                case "gif":$tipo = "image/gif";
                    break;
                case "png":$tipo = "image/png";
                    break;
                case "jpg":$tipo = "image/jpg";
                    break;
                case "mp3":$tipo = "audio/mpeg";
                    break;
                case "php":break; // deixar vazio por seurança
                case "htm":break; // deixar vazio por seurança
                case "html":break; // deixar vazio por seurança

            }
            header("Content-Type: " . $tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: " . filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=" . basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        } else {
            $layout = new layoutModel('404', 'erro', '| Erro 404');
            include "view/home/404.php";
            unset($layout);
        }
    }
    public function minify()
    {
        $cssFiles = array(
            "css/bootstrap.min.css",
            "css/fa/css/font-awesome.css",
            "css/base.css",
            "css/layout.css",
            "css/components.css",
            "css/produtos.css",
            "css/hero.css",
        );
        $buffer = "";
        foreach ($cssFiles as $cssFile) {
            $buffer .= file_get_contents($cssFile);
        }
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(': ', ':', $buffer);
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        ob_start("ob_gzhandler");
        header('Cache-Control: public');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
        header("Content-type: text/css");
        echo ($buffer);
        ob_end_flush();
    }
    public function retornoSite($obj)
    {
        $ret = '';
        if ((isset($obj->{'SENHA'}) && ($obj->{'SENHA'}))) {
            $ret .= '<table class=\'table table-striped\'>';
            $ret .= '<tr><td>Senha</td><td>' . $obj->{'SENHA'} . '</td></tr>';
            $ret .= '<tr><td>Status</td><td>Autorizado</td></tr>';
            $ret .= '<tr><td>Cliente</td><td>' . $obj->{'CODCLIENTE'} . ' - ' . $obj->{'NOMECLIENTE'} . '</td></tr>';
            $ret .= '</table>';
        } else {
            switch ($obj->{'RETORNO'}) {
            case 1:
                $ret .= '<table class=\'table table-striped\'>';
                $ret .= '<tr><td>Senha</td><td>' . $obj->{'SENHA'} . '</td></tr>';
                $ret .= '<tr><td>Status</td><td>Autorizado</td></tr>';
                $ret .= '<tr><td>Cliente</td><td>' . $obj->{'CODCLIENTE'} . ' - ' . $obj->{'NOMECLIENTE'} . '</td></tr>';
                $ret .= '</table>';
                break;
            case 2:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Serial não informado</td></tr></table>';
                break;
            case 3:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Licença Inválida</td></tr></table>';
                break;
            case 4:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Licença Bloqueada. Entre em contato com o suporte da ABCS Informática - (19) 3866-1100.</td></tr></table>';
                break;
            case 5:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Serial Inválido</td></tr></table>';
                break;
            case 6:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Conta em aberto. Entre em contato com o setor finaceiro da ABCS Informática - (19) 3866-1100.</td></tr></table>';
                break;
            default:
                $ret .= '<table class=\'table table-striped\'><tr><td>Status</td><td>Retorno desconhecido. Entre em contato com o suporte da ABCS Informática - (19) 3866-1100.</td></tr></table>';
                break;
            }
        }
    
        return $ret;
    }

}
