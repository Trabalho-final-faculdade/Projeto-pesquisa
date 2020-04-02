<?php
session_start();

if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){

  require '../Model/conexao.php';
  require '../Model/Usuario.php';

  $u = new \App\Model\Usuario();

  $email = addslashes($_POST['email']);
  $senha = addslashes($_POST['senha']);

  if($u->logar($email, $senha) == true){
    if(isset($_SESSION['id'])){
      $_SESSION['nao_autenticado'] = false;
      header("Location: ../View/pagina-inicial.php");
    }else{
      $_SESSION['nao_autenticado'] = true;
      header("Location: ../View/tela-login.php");
      exit;
    }
  }else{
    $_SESSION['nao_autenticado'] = true;
    header("Location: ../View/tela-login.php");
    exit;
  }
}else{
  $_SESSION['nao_autenticado'] = true;
  header("Location: ../View/tela-login.php");
  exit;
}

 ?>
