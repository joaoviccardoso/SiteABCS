<?php
@require_once './model/layoutModel.php';

class ajudaController{
    public function ajuda(){
        $pagina = explode( '/', $_SERVER['REQUEST_URI']);
        if (isset($pagina[2])){
            switch($pagina[2]){
                case "index":
                    $this->index();
                break;
                case "":
                    $this->index();
                break;
                case "premium":
                    $this->premium();
                break;
                case "citrus":
                    $this->citrus();
                break;
                case "mosaico":
                    $this->mosaico();
                break;
                case "nfe":
                    $this->nfe();
                break;
                case "sysin":
                    $this->sysin();
                break;
                case "cte":
                    $this->cte();
                break;
                case "sat":
                    $this->sat();
                break;
                case "mdfe":
                    $this->mdfe();
                break;
                default:
                    $this->error404();
                break;
            }
        }else{
            $this->index();
        }
    }
    public function index(){
        $layout = new layoutModel('ajuda', 'ajuda, faq, abcs, sistemas, sistemas para empresas', ': Ajuda');  
        include "view/ajuda/index.php";
        unset($layout);
    }
    public function premium(){
        $layout = new layoutModel('ajuda', 'ajuda, premium, gerenciador comercial, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Premium');  
        include "view/ajuda/premium.php";
        unset($layout);
    }
    public function citrus(){
        $layout = new layoutModel('ajuda', 'ajuda, citrus, gerenciador de fazendas, citricultura, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Citrus');  
        include "view/ajuda/citrus.php";
        unset($layout);
    }
    public function mosaico(){
        $layout = new layoutModel('ajuda', 'ajuda, mosaico, gerenciador de moteis, motelaria, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Mosaico');  
        include "view/ajuda/mosaico.php";
        unset($layout);
    }
    public function nfe(){
        $layout = new layoutModel('ajuda', 'ajuda, nfe, emissor de nfe, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS NFe');  
        include "view/ajuda/nfe.php";
        unset($layout);
    }
    public function mdfe(){
        $layout = new layoutModel('ajuda', 'ajuda, mdfe, emissor de mdfe, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS MDFe');  
        include "view/ajuda/mdfe.php";
        unset($layout);
    }
    public function cte(){
        $layout = new layoutModel('ajuda', 'ajuda, cte, emissor de cte, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Mosaico');  
        include "view/ajuda/cte.php";
        unset($layout);
    }
    public function sat(){
        $layout = new layoutModel('ajuda', 'ajuda, sat, emissor de sat, nfce, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Mosaico');  
        include "view/ajuda/sat.php";
        unset($layout);
    }
    public function sysin(){
        $layout = new layoutModel('ajuda', 'ajuda, sysin, gerenciador de hoteis, hotelaria, faq, abcs, sistemas, sistemas para empresas', ': Ajuda com o ABCS Mosaico');  
        include "view/ajuda/sysin.php";
        unset($layout);
    }
    public function error404(){
        $layout = new layoutModel('404', 'erro', '| Erro 404');  
        include "view/home/404.php";
        unset($layout);
    }
}