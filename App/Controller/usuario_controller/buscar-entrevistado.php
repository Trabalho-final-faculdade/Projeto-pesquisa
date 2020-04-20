<?php
session_start();

if(isset($_POST['cpf']) && !empty($_POST['cpf'])
&& isset($_SESSION['empresa_id']) && !empty($_SESSION['empresa_id'])){

require '../../Model/Conexao.php';
require '../../Model/Usuario.php';
require '../../Model/UsuarioDao.php';

$ud = new \App\Model\UsuarioDao();

    $resultado = $ud->buscar_entrevistado($_POST['cpf'], $_SESSION['empresa_id']);
    if(isset($resultado)){
        $_SESSION['id_entrevistado'] = $resultado[0]['id'];
        header("Location: ../../View/pesquisa/pesquisa.php");
    }else{
        header("Location: ../../View/usuario/verifica-usuario-pesquisa.php");
    }
    
}

?>
