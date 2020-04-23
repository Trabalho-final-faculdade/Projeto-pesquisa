<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){

require '../../Model/Conexao.php';
require '../../Model/Usuario.php';
require '../../Model/UsuarioDao.php';

$ud = new \App\Model\UsuarioDao();

    if($ud->bloquear_usuario($_GET['id'])){
        $_SESSION['bloqueado'] = true;
        header("Location: ../../View/usuario/buscar-usuarios.php");
    }else{
        $_SESSION['bloqueado'] = false;
        header("Location: ../../View/usuario/verifica-usuario-pesquisa.php");
    }
    
}

?>
