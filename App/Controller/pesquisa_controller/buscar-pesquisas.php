<?php
session_start();
echo "teste";
if(isset($_POST['email']) && !empty($_POST['email'])){

  require '../../Model/Conexao.php';
  require '../../Model/EnviarPesquisaDao.php';

  $u = new \App\Model\EnviarPesquisaDao();

  $email = addslashes($_POST['email']);
  $resultado = $u->buscar_pesquisas_nao_realizadas($email);
  
  if(isset($resultado) && !empty($resultado)){
      $_SESSION['nao_encontrado'] = false;
      header("Location: ../../../pesquisa-fechada.php?email=".$resultado[0]['email']);
  }else{
    $_SESSION['nao_encontrado'] = true;
    header("Location: ../../View/pesquisa/pesquisa-fechada.php");
    exit;
  }
}else{
  $_SESSION['nao_encontrado'] = true;
  header("Location: ../../View/pesquisa/pesquisa-fechada.php");
  exit;
}
?>