<?php

class utilModel{
  public function logado(){
    @require './const/const.php';
    session_start();

    if(isset($_SESSION['usuario'])){
      $usuario = $_SESSION['usuario'] ;
      $qry = 'SELECT * FROM usuario u WHERE u.usuario="'.$usuario.'"';
      $qry = mysqli_query($conn, $qry);
      
      if($row = mysqli_fetch_array($qry)){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  public function logar($username, $password){
    @require './const/const.php';
    $qry = 'SELECT * FROM usuario WHERE usuario="'.$username.'" AND senha = "'.$password.'" LIMIT 1 ';

    if ($qry = mysqli_query($conn, $qry)){
      if($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)){
        session_start();
        $_SESSION['usuario'] = $username;
        $_SESSION['senha'] = $password;
        return true;
      }else{
      return false;
      }
    }else{
      return false;
    }
  }

  public function converter_data($data) {
    $dataaux = explode('-',$data );
    $dataaux = array_reverse( $dataaux );
    return( implode( '/', $dataaux ) );
  }
}