<?php
@require_once './model/layoutModel.php';

class homeController{
  public function index(){
    $layout = new layoutModel('home', 'manutenção de computadores, santa ficha, emissor de nfe, abcs, sistemas, sistemas para empresas', '| Soluções para Empresas : Sistemas Empresariais e Manutenção de Computadores');
    include "view/home/index.php";
    unset($layout);
  }
  public function notFound404(){
    $layout = new layoutModel('404', 'erro', '| Erro 404');
    include "view/home/404.php";
    unset($layout);
  }
  public function internal500(){
    $layout = new layoutModel('500', 'erro', '| Erro 500');
    include "view/home/500.php";
    unset($layout);
  }
  public function manutencao(){
    $layout = new layoutModel('manutencao', 'manutencao', '| Conteúdo em Manutenção');
    include "view/home/manutencao.php";
    unset($layout);
  }
  
  public function download(){
    $layout = new layoutModel('download', 'download', '| Download de aplicativos para ajudar com seu sistema ABCS');
    include "view/home/download.php";
    unset($layout);
  }

  public function bolao(){
    $util = new utilModel();

    $pagina = explode( '/', $_SERVER['REQUEST_URI']);
    if (isset($pagina[2])){
        switch($pagina[2]){
            case "estat":
              $layout = new layoutModel('bolao', 'bolao', '| Bolão da Copa do Mundo de 2018');
              include "view/modelo/bolao.php";
              include "bolao/estat.html";
              echo "</div>";
              unset($layout);
            break;

            case "estat.html":
              $layout = new layoutModel('bolao', 'bolao', '| Bolão da Copa do Mundo de 2018');
              include "view/modelo/bolao.php";
              include "bolao/estat.html";
              echo "</div>";
              unset($layout);
            break;

            case "regulamento":
              $layout = new layoutModel('bolao', 'bolao', '| Bolão da Copa do Mundo de 2018');
              include "view/modelo/bolao.php";
              include "bolao/regulamento.php";
              echo "</div>";
              unset($layout);
            break;
            default:
              $layout = new layoutModel('bolao', 'bolao', '| Bolão da Copa do Mundo de 2018');
              include "view/modelo/bolao.php";
              include "bolao/index.html";
              echo "</div>";
              unset($layout);
            break;
          }
        }else{
          $layout = new layoutModel('bolao', 'bolao', '| Bolão da Copa do Mundo de 2018');
          include "view/modelo/bolao.php";
          include "bolao/index.html";
          echo "</div>";
          unset($layout);
      }


  }

}
