<?php
@require_once './model/layoutModel.php';

class pageController{
  public function nfe(){
    $layout = new layoutModel('NFe', 'nfe, emissor de nfe, abcs, sistemas, sistemas para empresas', 'NFe : Emissão e Gerenciamento de Nota Fiscal Eletrônica');  
    include "view/page/nfe.php";
    unset($layout);
  }
  public function cte(){
    $layout = new layoutModel('CTe', 'cte, emissor de cte, abcs, sistemas, sistemas para empresas', 'CTe : Emissão e Gerenciamento de Conhecimento de Transporte');  
    include "view/page/cte.php";
    unset($layout);
  }
  public function premium(){
    $layout = new layoutModel('premium', 'gerenciador comercial, abcs, sistemas, sistemas para empresas', 'Premium : Gerenciador para Empresas');  
    include "view/page/premium.php";
    unset($layout);
  }
  public function citrus(){
    $layout = new layoutModel('citrus', 'gerenciador para fazendas, citricultura, abcs, sistemas, sistemas para empresas', 'Citrus : Gestão de Fazendas de Citricultura');  
    include "view/page/citrus.php";
    unset($layout);
  }
  public function mosaico(){
    $layout = new layoutModel('mosaico', 'gerenciador para moteis, motelaria, abcs, sistemas, sistemas para empresas', 'Mosaico : Segurança e Gestão para Motéis');  
    include "view/page/mosaico.php";
    unset($layout);
  }
  public function sat(){
    $layout = new layoutModel('sat', 'SAT, NFCe, emissor de NFCe, motelaria, abcs, sistemas, sistemas para empresas', 'SAT : Emissão e Gerenciamento de Cupom SAT');  
    include "view/page/sat.php";
    unset($layout);
  }
  public function sysin(){
    $layout = new layoutModel('sysin', 'gerenciador para hoteis, hotelaria, abcs, sistemas, sistemas para empresas', 'SysIn : Segurança e Gestão para Hotéis');  
    include "view/page/sysin.php";
    unset($layout);
  }
  public function mdfe(){
    $layout = new layoutModel('mdfe', 'mdfe, transporte, manifesto, abcs, sistemas, sistemas para empresas', 'MDFe : Emissão e Gerenciamento de Manifesto de Transporte');  
    include "view/page/mdfe.php";
    unset($layout);
  }
  public function sobre()
  {
    $layout = new layoutModel('sobre', 'sobre, empresa, abcs informática, tecnologia, suporte, infraestrutura de ti', 'Sobre a ABCS Informática : Nossa história, missão, visão e valores');
    include "view/page/sobre.php";
    unset($layout);
  }
 
}