<?php
session_start();

if(isset($_POST['observacao']) && !empty($_POST['observacao'])
&& isset($_POST['data_final']) && !empty($_POST['data_final'])
&& isset($_POST['data_inicial']) && !empty($_POST['data_inicial'])
&& isset($_POST['titulo']) && !empty($_POST['titulo'])){

    require '../../Model/Conexao.php';
    require '../../Model/Pesquisa.php';
    require '../../Model/PesquisaDao.php';
    require '../../Model/EnviarPesquisaDao.php';

    $p = new \App\Model\Pesquisa();
    $pd = new \App\Model\PesquisaDao();
    $ep = new \App\Model\EnviarPesquisaDao();

    $p->setObservacao(addslashes($_POST['observacao']));
    $p->setDataFinal(addslashes($_POST['data_final']));
    $p->setDataInicial(addslashes($_POST['data_inicial']));
    $p->setTitulo(addslashes($_POST['titulo']));
    $p->setStatus("em andamento");
    $p->setFechada(addslashes($_POST['select_pesquisa']));

    if($p->getFechada() == '1'){
      $arquivo = $_FILES['arquivos']['tmp_name'];
      $nome = $_FILES['arquivos']['name'];
      $i = 0;

      $array_emails;
      $ext = explode(".", $nome);
      $extensao = end($ext);

      if($extensao != "csv"){
        $_SESSION['arquivo_invalido'] = true;
          header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
      }else{

        if($pd->create($p)){
          $resultado = $pd->buscar_pesquisas_titulo($_POST['titulo']);
          
          $objeto = fopen($arquivo, 'r');
          while(($dados = fgetcsv($objeto, 1000, ";")) !== FALSE){
              $ep->create($resultado[0]['id'], $dados[0]);
          } 
          
          $_SESSION['pesquisa_cadastrada'] = true;
          header("Location: ../../View/pergunta/cadastrar-pergunta.php?id=".$resultado[0]['id']);
        }else{
          header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
        }
      }
    }else{
      if($pd->create($p)){      
        $resultado = $pd->buscar_pesquisas_titulo($_POST['titulo']);
        $_SESSION['pesquisa_cadastrada'] = true;
        header("Location: ../../View/pergunta/cadastrar-pergunta.php?id=".$resultado[0]['id']);
      }else{
        $_SESSION['pesquisa_cadastrada'] = false;
        header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
      }
    }
}else{
    header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
}

?>
