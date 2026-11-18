<?php
@require './const/const.php';

class apiController{
    public function index(){
        $pagina = explode( '/', $_SERVER['REQUEST_URI']);
        if(isset($pagina[2])){
            switch($pagina[2]){
                case "envio":
                    $this->envio();
                break;
                default:
                    $this->respostaPadrao();
                break;
            }
        }else{
            $this->respostaPadrao();
        }
    }
    public function respostaPadrao(){
        http_response_code(200); 
        echo('Bem-Vindo a api da ABCS Informática. Parece que você fez uma requisição inválida ou inexistente.');
    }
    public function envio(){//vai mudar aqui
        if($_GET){
            $sistema = $_GET['sistema'];
            $emissor = $_GET['emissor'];
            $chave = $_GET['chave'];
            $licenca = $_GET['licenca'];
        
            $qry = 'INSERT INTO abcs_produtos.emissoes(sistema, emissor, chave, licenca) VALUES("'.$sistema.'","'.$emissor.'","'.$chave.'","'.$licenca.'")';
            mysqli_query($conn, $qry);
            http_response_code(200);
        }
        else{
            http_response_code(405);
            echo('405 - Não permitida a operação');
        }
    } 
}