<?php

session_start();

if(isset($_POST['indice']) 
&& isset($_POST['pesquisa']) && !empty($_POST['pesquisa'])
&& isset($_POST['pergunta']) && !empty($_POST['pergunta'])
&& isset($_POST['operador']) && !empty($_POST['operador'])
&& isset($_POST['entrevistado']) && !empty($_POST['entrevistado']) 
&& isset($_POST['resposta']) && !empty($_POST['resposta'])){

    require '../Model/conexao.php';
    require '../Model/Questionario.php';
    require '../Model/QuestionarioDao.php';
    
    $q = new \App\Model\Questionario();
    $qd = new \App\Model\QuestionarioDao();
    $converter_array = serialize($_POST['resposta']);
    $q->setPesquisaId(addslashes($_POST['pesquisa']));
    $q->setPerguntaId(addslashes($_POST['pergunta']));
    $q->setOperadorId(addslashes($_POST['operador']));
    $q->setEntrevistadoId(addslashes($_POST['entrevistado']));
    $q->setRespostaId(addslashes($converter_array));

    $numero = $_POST['indice'] + 1;
    if($qd->create($q)){
        $_SESSION['indice'] = $numero;
        $_SESSION['pesquisa_id'] = $_POST['pesquisa'];
        header("Location: ../View/pesquisa.php");
    }else{
        return false;
    }
}

?>