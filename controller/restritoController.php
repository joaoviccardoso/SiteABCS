<?php
@require_once './model/layoutModel.php';
@require_once './model/utilModel.php';
@require_once './model/emailModel.php';
require_once './lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class restritoController
{
    private $util;
    private function aviso($tipoAviso, $usuario)
    {
        date_default_timezone_set('America/Sao_Paulo');
        if ($tipoAviso == "T") {
            $assunto = "Excesso de tentativas de login para o usuário " . $usuario;
            $texto = "Excesso de tentativas de login para o usuário " . $usuario;
            $email = new emailModel("luis@abcsinformatica.com.br", "Luis", 'Área Restrita:' . $assunto, $texto, "contato@abcsinformatica.com.br", "Site ABCS");
        } else if ($tipoAviso == "L") {
            session_start();
            $assunto = "Login na área restrita: " . $usuario;
            $texto = "Foi verificado um login na área restrita em " . Date("d/m/y G:i:s") . ". Caso seja você apenas ignore.";
            $email = new emailModel("i@santaficha.com.br", "Login restrito:", 'Área Restrita:' . $assunto, $texto, "contato@abcsinformatica.com.br", "Site ABCS");
        }
    }

    public function restrito()
    {
        $util = new utilModel();

        $pagina = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($pagina[2])) {
            if (($util->logado() == true)) {
                switch ($pagina[2]) {
                    case "index":
                        $this->paginaInicial();
                        break;
                    case "login":
                        $this->paginaInicial();
                        break;
                    case "":
                        $this->paginaInicial();
                        break;
                    case "emails":
                        $this->emails();
                        break;
                    case "boletos":
                        $this->boletos();
                        break;
                    case "download":
                        $this->download();
                        break;
                    case "downloadsistemas":
                        $this->downloadsistemas();
                        break;
                    case "enviarArquivo":
                        $this->enviarArquivo();
                        break;
                    case "upload":
                        $this->upload();
                        break;
                    case "baixar":
                        $this->baixar();
                        break;
                    case "baixarsistema":
                        $this->baixarsistema();
                        break;
                    case "relatorioNeolink":
                        $this->relatorioNeolink();
                        break;
                    case "pdfRelatorio":
                        $this->pdfRelatorio();
                        break;
                    case "sair":
                        $this->sair();
                        break;

                    default:
                        $this->error404();
                        break;
                }
            } else {
                switch ($pagina[2]) {
                    case "index":
                        $this->index();
                        break;
                    case "":
                        $this->index();
                        break;
                    case "login":
                        $this->logar();
                        break;
                    default:
                        $this->error404();
                        break;
                }
            }
        } else {
            $this->index();
        }
    }

    public function index()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        include "view/restrito/index.php";
        unset($layout);
    }

    public function error404()
    {
        $layout = new layoutModel('404', 'erro', '- Erro 404');
        include "view/home/404.php";
        unset($layout);
    }
    public function error500()
    {
        $layout = new layoutModel('500', 'erro', '- Erro 500');
        include "view/home/500.php";
        unset($layout);
    }
    public function upload()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        include "view/restrito/upload.php";
        unset($layout);
    }
    public function enviarArquivo()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        if (isset($_FILES["arquivo"])) {
            $foto = $_FILES["arquivo"];
            if (!empty($foto["name"])) {
                $caminho_imagem = "./arquivo/" . $foto["name"];
                if (move_uploaded_file($foto["tmp_name"], $caminho_imagem)) {
                    include "view/restrito/upload.php";
                    echo '<div class="alert alert-success" role="alert">';
                    echo 'Envio Realizado com sucesso.';
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo 'Problemas no envio. tente novamente.';
                    echo '</div>';
                }

            }
        }

        unset($layout);
    }

    public function paginaInicial()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        include "view/restrito/paginaInicial.php";
        unset($layout);
    }
    public function logar()
    {
        $util = new utilModel();
        if ($_POST) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if ($util->logar($username, $password) == true) {
                $this->aviso("L", $username);
                header('Location: .\index ');
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
        unset($util);
    }
    public function emails()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        @require './const/const.php';
        $qry = "SELECT * FROM email ORDER BY idemail DESC";
        $res = mysqli_query($conn, $qry);

        include "view/restrito/emails.php";
        unset($layout);
    }
    public function emailTD($email)
    {
        if ($email['recebido'] == 1) {
            $status = "<tr class = \"bg-success\"><td>" . $email['idemail'] . "</td><td><p>" . $email['hora_envio'] . "</p></td><td><p> " . $email['hora_leitura'] . "</p>";
        } else if ($email['enviado'] == 1) {
            $status = "<tr class = \"bg-info\"><td>" . $email['idemail'] . "</td><td><p>" . $email['hora_envio'] . "</p></td><td>Não lido";
        } else {
            $status = "<tr class = \"bg-danger\"><td>" . $email['idemail'] . "</td><td><p><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Não Enviado</p>";
        }
        return $status . "</td><td>" . $email['nome_dest'] . ' : ' . $email['email_dest'] . "</td><td>" . $email['nome_rem'] . ' : ' . $email['email_rem'] . "</td><td>" . $email['assunto'] . "</td><td>" . substr(str_replace(array('<', '>'), array('&lt', '&gt'), $email['mensagem']), 278, 200) . "...</td></tr>";
    }
    public function boletos()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');

        $idcon = mysqli_connect("mysql.conchalnet.com.br", "boleto", "ab@cs.bol", 'provedor_novo') or die('Erro ao conectar com o banco de dados! ' . db_error());
        mysqli_set_charset($idcon, 'utf8');
        $idqry = mysqli_query($idcon, "SELECT * FROM provedor_novo.boletoabcs b INNER JOIN provedor_novo.clientes c ON b.cnpjcpfnum = c.cnpjcpf GROUP BY  b.cnpjcpfnum ORDER BY b.nome ");

        include "view/restrito/boletos.php";
        unset($layout);
    }
    public function MostrarBoleto($reg)
    {
        $util = new utilModel();
        $idcon = mysqli_connect("mysql.conchalnet.com.br", "boleto", "ab@cs.bol", 'provedor_novo') or die('Erro ao conectar com o banco de dados! ' . db_error());
        if ($reg["email_adic"] != '') {
            echo "<div class = 'col-md-3 align-middle'><h4><input type='checkbox' id='cnpjcpf" . $reg["cnpjcpf"] . "' name='cnpjcpf[]' value='" . $reg["cnpjcpf"] . "'>";
            echo $reg["nome"] . "</div></h4>";
            echo "<div class = 'col-md-9'><table class = \"table table-responsive table-sm\">";
            echo "<thead class='thead-inverse'><th></th><th></th><th>Nosso Número</th><th>Vencimento</th><th>Valor</th><th>Detalhes da Fatura</th></thead>";
            $codigo = $reg["cnpjcpfnum"];
            $qry = "select boletoabcs.*, datediff(CURDATE(),datavenc) as atraso from boletoabcs where cnpjcpfnum=$codigo";
            $queryboletos = mysqli_query($idcon, $qry);
            while ($boleto = mysqli_fetch_array($queryboletos)) {
                $hoje = date("Y-m-d");
                $anteontem = date("Y-m-d", time() - 172800);
                $class = "";
                $agora = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                if ($hoje > $boleto["datavenc"]) {
                    $class = "class=\"bg-danger\"";
                    $boleto["juros"] = $boleto["juros"] / 100;
                    $boleto["multa"] = $boleto["multa"] / 100;
                    if (date("w", $agora) == 1) {
                        if (($anteontem > $boleto["datavenc"])) {
                            $boleto["valorvenc"] = round($boleto["valorvenc"] + ($boleto["valorvenc"] * $boleto["multa"]) + ($boleto["valorvenc"] * $boleto["atraso"] * $boleto["juros"]), 2);
                        }

                    } else {
                        $boleto["valorvenc"] = round($boleto["valorvenc"] + ($boleto["valorvenc"] * $boleto["multa"]) + ($boleto["valorvenc"] * $boleto["atraso"] * $boleto["juros"]), 2);
                    }
                }
                $link = "<a href=\"http://abcsinformatica.com.br/boleto/boleto.php?gerar=s&codbol=$boleto[codigo]\" target='_blank'>";
                echo "<tr $class><td><input type='checkbox' id='boleto" . $reg["cnpjcpf"] . "' name='boleto[]' value='" . $boleto["codigo"] . "'></td><td with=\"42\" >$link<img src=\"http://abcsinformatica.com.br/boleto/boleto.gif\" border=\"0\" /></a>";
                echo "<td>$boleto[nossonr] </a></td>";
                echo "<td>";
                echo $util->converter_data($boleto['datavenc']);
                echo "</td>";
                echo "<td>" . number_format($boleto['valorvenc'], 2) . "</td>";
                echo "<td>" . $boleto['detalhe'] . "</td>";
                echo "</tr>";
            }
            echo "</table></div>";
        }
        unset($util);
    }
    public function download()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        include "view/restrito/download.php";
        unset($layout);
    }
    public function downloadsistemas()
    {
        $layout = new layoutModel('restrito', '', '- Restrito');
        include "view/restrito/downloadsistemas.php";
        unset($layout);
    }
    public function mostrarArquivos()
    {
        $arquivos = ' ';
        if ($handle = opendir('./arquivo')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {

                    $info = explode(".", $entry);
                    $nome = str_replace('.', '__', $entry);
                    $arquivos .= '<a class="black col-md-2 col-sm-4 col-xs-6 text-center  badge badge-light" href="baixar/' . $nome . '">';
                    $arquivos .= '<h1><i class="';
                    switch (end($info)) {
                        case "exe":
                            $arquivos .= 'fa fa-cog';
                            break;
                        case "apk":
                            $arquivos .= 'fa fa-mobile';
                            break;
                        case "zip":
                            $arquivos .= 'fa fa-file-archive-o';
                            break;
                        case "png":case "jpg":
                            $arquivos .= 'fa fa-picture-o';
                            break;
                        default:
                            $arquivos .= 'fa fa-file-o';
                            break;
                    }
                    $arquivos .= '" aria-hidden="true"></i></h1>';
                    $arquivos .= '<p>' . $entry . '</p>';
                }
            }
            closedir($handle);
        }
        return $arquivos;
    }

    public function baixar()
    {
        $pagina = explode('/', $_SERVER['REQUEST_URI']);
        $nome = str_replace('__', '.', $pagina[3]);
        $arquivo = './arquivo/' . $nome;
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
                case "php": // deixar vazio por seurança
                case "htm": // deixar vazio por seurança
                case "html": // deixar vazio por seurança
            }
            header("Content-Type: " . $tipo); // informa o tipo do arquivo ao navegador
            header("Content-Length: " . filesize($arquivo)); // informa o tamanho do arquivo ao navegador
            header("Content-Disposition: attachment; filename=" . basename($arquivo)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
            readfile($arquivo); // lê o arquivo
            exit; // aborta pós-ações
        }
    }
    public function baixarsistema()
    {
        $pagina = explode('/', $_SERVER['REQUEST_URI']);
        $nome = str_replace('__', '.', $pagina[3]);
        $arquivo = './sistemas/' . $nome;
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
                case "php": // deixar vazio por seurança
                case "htm": // deixar vazio por seurança
                case "html": // deixar vazio por seurança
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
    public function sair()
    {
        session_start();
        session_destroy();
        header('Location: .\ ');

    }
    public function relatorioNeolink()
    {
        @require './const/const.php';

        $i = 0;
        $pdvs;
        $qry = 'SELECT DISTINCT p.idpdv FROM pagamentosTestes p ORDER BY p.idpdv';
        $res = mysqli_query($conn, $qry);
        while ($opcoes = mysqli_fetch_array($res)) {
            $pdvs[$i] = $opcoes['idpdv'];
            $i++;
        }

        $qry = 'SELECT * FROM pagamentosTestes p WHERE 1 ';

        if (isset($_POST['data']) && ($_POST['data'] != '')) {
            $qry .= 'AND CAST(p.datahora AS DATE) = "' . $_POST['data'] . '" ';
            $data = $_POST['data'];
        }

        if (isset($_POST['idpdv']) && ($_POST['idpdv'] != '')) {
            $qry .= 'AND p.idpdv = "' . $_POST['idpdv'] . '" ';
            $idpdv = $_POST['idpdv'];
        }

        $qry .= 'ORDER BY p.codigo DESC ';

        if ($res = mysqli_query($conn, $qry)) {
            $layout = new layoutModel('Relatório', 'relatorio', '- Relatorio');
            include "view/restrito/relatorioNeolink.php";
            unset($layout);
        } else {
            $this->error500();
        }
    }

    public function pagamentostable($res, $imprimeTodos = true)
    {$valorTotal = 0;
        $qtdeTotal = 0;
        $status = '';
        $status .= '<table class="table  table-striped table-bordered table-sm"><thead><tr><th scope="col">Cobrança</th><th scope="col">Cliente</th><th scope="col">Valor Pago</th><th scope="col">Data/Hora</th>';
        $status .= '<th scope="col">Forma de Pagamento</th>';

        if ($imprimeTodos) {
            $status .= '<th scope="col">Terminal</th><th scope="col">Autorização</th><th scope="col">NSU</th></tr>';
        }
        $status .= '</thead><tbody>';

        while ($pagamento = mysqli_fetch_array($res)) {

            if ($pagamento['tipotransacao'] == 6) {
                $formapagamento = 'Cartão Crédito';
            } else if ($pagamento['tipotransacao'] == 7) {
                $formapagamento = 'Cartão Débito';
            } else {
                $formapagamento = 'Outros';
            }
            $valorTotal += $pagamento['valorpago'];
            $qtdeTotal++;

            $status .= "<tr><td>" . $pagamento['cobranca'] . "</td><td><p>" . $pagamento['codcliente'] . ' - ' . $pagamento['nome'] . "</p></td><td><p> R$" . number_format($pagamento['valorpago'], 2, ',', '.') . "</p>" . "</td><td>" . date("d/m/Y H:i:s", strtotime($pagamento['datahora'])) . "</td>";
            $status .= "<td>" . $pagamento['tipotransacao'] . ' - ' . $formapagamento . "</td>";
            if ($imprimeTodos) {
                $status .= "<td><p>" . $pagamento['idpdv'] . "</p></td><td><p> " . $pagamento['tefaut'] . "</p>" . "</td><td>" . $pagamento['tefnsu'] . "</td>";
            }
            $status .= "</tr>";
        }

        $status .= '</tbody></table>';
        $status .= '<p  class="text-right">Quantidade de pagamentos: ' . $qtdeTotal . '</p>';
        $status .= '<p  class="text-right">Valor Total: R$' . number_format($valorTotal, 2, ',', '.') . '</p>';

        return $status;
    }
    public function pdfRelatorio()
    {
        @require './const/const.php';
        $loadhtml .= '<html> <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"><body>';

        $qry = 'SELECT * FROM pagamentosTestes p WHERE 1 ';
        $pagina = explode('/', $_SERVER['REQUEST_URI']);
        if ((isset($pagina[3])) && ($pagina[3] != '')) {
            $qry .= 'AND CAST(p.datahora AS DATE) = "' . $pagina[3] . '" ';
            $loadhtml .= '<h2>Data:' . $pagina[3] . '</h2>';
        }
        if ((isset($pagina[4])) && ($pagina[4] != '')) {
            $qry .= 'AND p.idpdv = "' . $pagina[4] . '" ';
            $loadhtml .= '<h2>Terminal:' . $pagina[4] . '</h2>';
        }
        $qry .= 'ORDER BY p.codigo DESC ';

        if ($res = mysqli_query($conn, $qry)) {

            $loadhtml .= $this->pagamentostable($res, false);
            $loadhtml .= '</body></html>';
            //echo $loadhtml;
            $options = new Options();
            $options->setChroot(realpath('.'));
            $dompdf = new Dompdf($options);
            $dompdf->setBasePath(realpath('.'));
            $dompdf->loadHtml($loadhtml);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream(
                "pagamentos.pdf",
                array(
                    "Attachment" => false,
                )
            );

        } else {
            $this->error500();
        }

    }
}
