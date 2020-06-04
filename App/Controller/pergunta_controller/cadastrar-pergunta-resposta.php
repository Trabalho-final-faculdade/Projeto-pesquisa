<?php  

session_start();

if(isset($_POST['pesquisa']) && !empty($_POST['pesquisa']) 
&& isset($_POST['pergunta']) && !empty($_POST['pergunta']) 
&& isset($_POST['tipo_pergunta']) && !empty($_POST['tipo_pergunta'])
&& isset($_POST['titulo']) && !empty($_POST['titulo'])){

    require '../../Model/Conexao.php';
    require '../../Model/Resposta.php';
    require '../../Model/RespostaDao.php';
    require '../../Model/Pergunta.php';
    require '../../Model/PerguntaDao.php';
    require '../../Model/EscalaPerguntaDao.php';

    $p = new \App\Model\Pergunta();
    $pd = new \App\Model\PerguntaDao();
    $r = new \App\Model\Resposta();
    $rd = new \App\Model\RespostaDao();
    $escala_dao = new \App\Model\EscalaPerguntaDao();

    $p->setPesquisaId(addslashes($_POST['pesquisa']));
    $p->setPergunta(addslashes($_POST['pergunta']));
    $p->setTipoPergunta(addslashes($_POST['tipo_pergunta']));

    if($pd->create($p)){
        $resultado = $pd->buscar_pergunta_nome($_POST['pergunta']);
        foreach($_POST['titulo'] as $titulo):
            $rd->create($titulo, $resultado[0]['id']);
        endforeach;
        foreach($_POST['escala'] as $escala):
            $escala_dao->create($resultado[0]['id'], $escala);
        endforeach;
        header("Location: ../../View/pergunta/cadastrar-pergunta.php?id=".$_POST['pesquisa']); 
    }else{
        $_SESSION['cadastro_sucesso'] = false;
    }
}else{
  header("Location: ../../View/sistema/pagina-inicial.php");
}

?> 