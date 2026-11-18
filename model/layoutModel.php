<?php

class layoutModel{
  public $dot;
  public $whitelist;
  public function __construct($page, $keywords, $title) {
    $this->layout($page, $keywords, $title);
  }
  public function retornaDot($page){
    if($page=='home') {
     return '.';
    } else {
      return '..';
    }
  }
  public function layout($page, $keywords, $title){
    $whitelist = array(
      '127.0.0.1',
      '::1'
    );
    $dot = $this->retornaDot($page);
    include "view/modelo/layout.php";
  }

}
?>