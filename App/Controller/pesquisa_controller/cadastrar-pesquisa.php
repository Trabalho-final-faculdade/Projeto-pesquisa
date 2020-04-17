<?php
session_start();

if(isset($_POST['observacao']) && !empty($_POST['observacao'])
&& isset($_POST['data_final']) && !empty($_POST['data_final'])
&& isset($_POST['data_inicial']) && !empty($_POST['data_inicial'])
&& isset($_POST['titulo']) && !empty($_POST['titulo'])){

    require '../Model/conexao.php';
    require '../Model/Pesquisa.php';
    require '../Model/PesquisaDao.php';

    $p = new \App\Model\Pesquisa();
    $pd = new \App\Model\PesquisaDao();

    $p->setObservacao(addslashes($_POST['observacao']));
    $p->setDataFinal(addslashes($_POST['data_final']));
    $p->setDataInicial(addslashes($_POST['data_inicial']));
    $p->setTitulo(addslashes($_POST['titulo']));
    $p->setStatus("em andamento");

    if($pd->create($p)){
       $resultado = $pd->buscar_pesquisas_titulo($_POST['titulo']);
       header("Location: ../View/pergunta/cadastrar-pergunta.php?id=".$resultado[0]['id']);
    }else{
       header("Location: ../View/pesquisa/cadastrar-pesquisa.php");
    }
    
}else{
    header("Location: ../View/pesquisa/cadastrar-pesquisa.php");
}
?>
