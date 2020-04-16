<?php  

session_start();

if(isset($_POST['pesquisa']) && !empty($_POST['pesquisa']) 
&& isset($_POST['pergunta']) && !empty($_POST['pergunta']) 
&& isset($_POST['tipo_pergunta']) && !empty($_POST['tipo_pergunta'])
&& isset($_POST['descricao']) && !empty($_POST['descricao'])){

    require '../Model/conexao.php';
    require '../Model/Resposta.php';
    require '../Model/RespostaDao.php';
    require '../Model/Pergunta.php';
    require '../Model/PerguntaDao.php';

    $p = new \App\Model\Pergunta();
    $pd = new \App\Model\PerguntaDao();
    $r = new \App\Model\Resposta();
    $rd = new \App\Model\RespostaDao();

    $p->setPesquisaId(addslashes($_POST['pesquisa']));
    $p->setPergunta(addslashes($_POST['pergunta']));
    $p->setTipoPergunta(addslashes($_POST['tipo_pergunta']));

    if($pd->create($p)){
        $resultado = $pd->buscar_pergunta_nome($_POST['pergunta']);
        foreach($_POST['descricao'] as $descricao):
            $rd->create($descricao, $resultado[0]['id']);
        endforeach;
        header("Location: ../View/cadastrar-pergunta.php?id=".$_POST['pesquisa']); 
       
    }else{
        $_SESSION['cadastro_sucesso'] = false;
    }
}else{
    header("Location: ../View/pagina-inicial.php");
}

?> 