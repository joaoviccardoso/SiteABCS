<?php

class utilModel
{
    public function logado()
    {
        @require './const/const.php';

        session_start();
        $username = $_SESSION['usuario'];
        $password = $_SESSION['senha'];

        $qry = 'SELECT * FROM usuario WHERE usuario="' . $username . '"';

        if ($password === $this->senha($username)) {
            if ($qry = mysqli_query($conn, $qry)) {
                if ($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function senha($usuario)
    {
        $diaMes = date('dm');
        $ano = date('Y');

        $senhaVar = $diaMes + $ano;
        return $usuario . $senhaVar;
    }
    public function logar($username, $password)
    {
        @require './const/const.php';
        $qry = 'SELECT * FROM usuario WHERE usuario="' . $username . '"';

        if ($password === $this->senha($username)) {
            if ($qry = mysqli_query($conn, $qry)) {
                if ($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)) {
                    session_start();

                    $_SESSION['usuario'] = $username;
                    $_SESSION['senha'] = $password;
                    $_SESSION['email'] = $row['email'];
                    return true;

                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function converter_data($data)
    {
        $dataaux = explode('-', $data);
        $dataaux = array_reverse($dataaux);
        return (implode('/', $dataaux));
    }
}
?>