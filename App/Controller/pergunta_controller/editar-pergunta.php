<?php
session_start();

if(isset($_POST['pergunta']) && !empty($_POST['pergunta']) 
&& isset($_POST['resposta']) && !empty($_POST['resposta'])
&& isset($_POST['tipo_pergunta']) && !empty($_POST['tipo_pergunta'])){


  require '../../Model/conexao.php';
  require '../../Model/Resposta.php';
  require '../../Model/RespostaDao.php';
  require '../../Model/Pergunta.php';
  require '../../Model/PerguntaDao.php';

  $p = new \App\Model\Pergunta();
  $pd = new \App\Model\PerguntaDao();

  $r = new \App\Model\Resposta();
  $rd = new \App\Model\RespostaDao();

  $p->setPergunta(addslashes($_POST['pergunta']));
  $p->setTipoPergunta(addslashes($_POST['tipo_pergunta']));
  $p->setId(addslashes($_POST['id']));
  
  if($pd->update($p)){
    $_SESSION['editar_pesquisa'] = true;
  }else{
    $_SESSION['editar_pesquisa'] = false;
  }

    if($rd->update($_POST['resposta'])){ 
        $_SESSION['editar_pergunta'] = true;
    }else{
        $_SESSION['editar_pergunta'] = false;
    }
  header("Location: ../../View/pesquisa/editar-dados-pesquisa.php?id=".$_POST['pesquisa_id']);      
}
    
?>
