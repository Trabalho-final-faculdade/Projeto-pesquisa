<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){

require '../../Model/Conexao.php';
require '../../Model/Usuario.php';
require '../../Model/UsuarioDao.php';

$ud = new \App\Model\UsuarioDao();

    if($ud->desbloquear_usuario($_GET['id'])){
        $_SESSION['desbloqueado'] = true;
        header("Location: ../../View/usuario/usuarios-bloqueados.php");
    }else{
        $_SESSION['desbloqueado'] = false;
        header("Location: ../../View/usuario/usuarios-bloqueados.php");
    }
    
}

?>
