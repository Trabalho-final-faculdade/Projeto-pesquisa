<?php
session_start();

if(isset($_POST['email']) && !empty($_POST['email'])
&& isset($_POST['senha']) && !empty($_POST['senha'])){

    require '../../Model/Conexao.php';
    require '../../Model/Usuario.php';
    require '../../Model/UsuarioDao.php';
    require '../../Model/Senha_recuperada.php';
    require '../../Model/Senha_recuperadaDao.php';

    $ud = new \App\Model\UsuarioDao();
    $sd = new \App\Model\SenhaRecuperadaDao();

    $resultado = $ud->verificar_email($_POST['email']);
    if(isset($resultado)){
        if($ud->alterar_senha($_POST['senha'], $resultado[0]['id']) == true){
            $sd->alterar_status($_POST['email']);
            $_SESSION['senha_alterada'] = true; 
            header("Location: ../../View/sistema/tela-login.php");

        }
    }else{
    $_SESSION['senha_alterada'] = false;
    header("Location: ../../View/sistema/tela-login.php");
    
    }
}
?>