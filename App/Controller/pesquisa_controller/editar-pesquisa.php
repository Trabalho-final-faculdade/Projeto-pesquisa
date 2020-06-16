<?php
session_start();

if(isset($_POST['id']) && !empty($_POST['id']) 
&& isset($_POST['titulo']) && !empty($_POST['titulo']) && isset($_POST['observacao']) && !empty($_POST['observacao']) 
&& isset($_POST['status']) && !empty($_POST['status'])){


  require '../../Model/Conexao.php';
  require '../../Model/Pesquisa.php';
  require '../../Model/PesquisaDao.php';

  $p = new \App\Model\Pesquisa();
  $pd = new \App\Model\PesquisaDao();

  $p->setTitulo(addslashes($_POST['titulo']));
  $p->setObservacao(addslashes($_POST['observacao']));
  $p->setStatus(addslashes($_POST['status']));
  $p->setId(addslashes($_POST['id']));
  

  if($pd->update($p)){
    $_SESSION['editar_pesquisa'] = true;
  }else{
    $_SESSION['editar_pesquisa'] = false;
  }
  header("Location: ../../View/pesquisa/editar-dados-pesquisa.php?id=".$_POST['id']); 
}



?>
