<?php
session_start();

if(isset($_POST['id']) && !empty($_POST['id']) 
&& isset($_POST['titulo']) && !empty($_POST['titulo']) && isset($_POST['data_inicial'])
&& !empty($_POST['data_inicial']) && isset($_POST['data_final']) && !empty($_POST['data_final']) 
&& isset($_POST['observacao']) && !empty($_POST['observacao']) 
&& isset($_POST['status']) && !empty($_POST['status'])){


  require '../../Model/conexao.php';
  require '../../Model/Pesquisa.php';
  require '../../Model/PesquisaDao.php';

  $p = new \App\Model\Pesquisa();
  $pd = new \App\Model\PesquisaDao();

  $p->setTitulo(addslashes($_POST['titulo']));
  $p->setDataInicial(addslashes($_POST['data_inicial']));
  $p->setDataFinal(addslashes($_POST['data_final']));
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
