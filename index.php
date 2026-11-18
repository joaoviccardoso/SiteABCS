<?php
header('Content-Type: text/html; charset=utf-8');
require_once "controller/homeController.php";
require_once "controller/functionController.php";
require_once "controller/apiController.php";
require_once "controller/pageController.php";
require_once "controller/ajudaController.php";
require_once "controller/restritoController.php";

$pagina = explode('/', $_SERVER['REQUEST_URI']);
$home = new homeController();
$function = new functionController();
$api = new apiController();
$page = new pageController();
$ajuda = new ajudaController();
$restrito = new restritoController();

switch ($pagina[1]) {
    //páginas básicas
    case "index":
        $home->index();
        break;
    case "":
        $home->index();
        break;
    case "bolao":
        $home->bolao();
        break;

    case "downloads":
        $home->download();
        break;
    case "bolaoabcs":
        $home->bolao();
        break;

    //páginas com funções
    case "senha":
        $function->senha();
        break;
    case "acesso":
        $function->senha();
        break;
    case "mail":
        $function->mail();
        break;
    case "email":
        $function->mail();
        break;
    case "boleto":
        //$home->manutencao();
        $function->boleto((isset($pagina[2])) ? $pagina[2] : '');
        break;
    case "contato":
        $function->contato();
        break;
    case "contatoRealizado":
        $function->contatoRealizado();
        break;
    case "t":
        $function->teamviewer();
        break;
    case "teamviewer":
        $function->teamviewer();
        break;
    case "sitemap":
        $function->sitemap();
        break;
    case "minify":
        $function->minify();
        break;
    case "pdvi":
        header('Location:https://drive.google.com/open?id=1JX8Hs8u2bGfdsJRfovnGi-Z3lv0ST8oU');
        break;
    case "pdvr":
        header('Location:https://drive.google.com/open?id=1-sw9cxMojQehJJKVbnMgemSMk_YB1-wQ');
        break;
/*   case "restaurantevenda":
$function->download('./arquivo/RestauranteVenda.exe');
break;*/
    case "pdv":
        header('Location:https://drive.google.com/file/d/1KANY-3SgArdwxEGF55gQlLEwsAlSMkJM/view?usp=sharing');
        break;

    case "download":
        header('Location:https://drive.google.com/file/d/1RIkiG7kBrnjU3WmQH_7qlAQeon9D63OA/view?usp=sharing');
        break;

    //gerenciador do restrito. SubRotas estão no controller
    case "restrito":
        $restrito->restrito();
        break;
    case "interno":
        $restrito->restrito();
        break;

    //gerenciador de api. SubRotas estão no controller
    case "api":
        $api->index();
        break;

    //páginas com somente texto
    case "nfe":
        $page->nfe();
        break;
    case "abcsnfe":
        $page->nfe();
        break;

    case "cte":
        $page->cte();
        break;
    case "abcscte":
        $page->cte();
        break;

    case "premium":
        $page->premium();
        break;
    case "abcspremium":
        $page->premium();
        break;

    case "citrus":
        $page->citrus();
        break;
    case "abcscitrus":
        $page->citrus();
        break;

    case "mosaico":
        $page->mosaico();
        break;
    case "abcsmosaico":
        $page->mosaico();
        break;

    case "sat":
        $page->sat();
        break;
    case "abcssat":
        $page->sat();
        break;

    case "sysin":
        $page->sysin();
        break;
    case "abcssysin":
        $page->sysin();
        break;

    case "mdfe":
        $page->mdfe();
        break;
    case "abcsmdfe":
        $page->mdfe();
        break;

    //Páginas de ajuda
    case "ajuda":
        $ajuda->ajuda();
        break;
    case "faq":
        $ajuda->ajuda();
        break;

    //Erros do Site
    case "manutencao":
        $home->manutencao();
        break;
    case "500":
        $home->internal500();
        break;
    case "404":
        $home->notFound404();
        break;
    default:
        $home->notFound404();
        break;
}
