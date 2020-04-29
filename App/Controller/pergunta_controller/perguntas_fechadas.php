<?php

use App\Model\QuestionarioDao;

session_start();

if(isset($_POST['pesquisa_id']) && $_POST['pesquisa_id'] != ''){
    
    require '../../Model/Conexao.php';
    require '../../Model/PerguntaDao.php';
    require '../../Model/RespostaDao.php';

    $r = new \App\Model\RespostaDao();
    $rd = new \App\Model\PerguntaDao();
    $resultado = '';
    if(isset($_POST['index'])){
        $index = $_POST['index'];
    }else{
        $index = 0;
    }

    if(isset($_POST['resposta_selecionada']) && $_POST['resposta_selecionada'] != '' 
    && isset($_POST['pergunta']) && $_POST['pergunta'] != '' 
    && isset($_POST['id_usuario']) && $_POST['id_usuario'] != ''){
        require '../../Model/Questionario.php';
        require '../../Model/QuestionarioDao.php';

        $questionario = new \App\Model\Questionario();
        $questionarioDao = new \App\Model\QuestionarioDao();

        $questionario->setEntrevistadoId(addslashes($_POST['id_usuario']));
        $questionario->setRespostaId(addslashes($_POST['resposta_selecionada']));
        $questionario->setPerguntaId(addslashes($_POST['pergunta']));
        $questionario->setPesquisaId(addslashes($_POST['pesquisa_id']));
        $questionario->setOperadorId(null);

        $questionarioDao->create($questionario);
    }

    $perguntas = $rd->buscar_pergunta_pesquisa($_POST['pesquisa_id']);

    if(isset($perguntas[$index]['id']) && !empty($perguntas[$index]['id'])){
        $resposta = $r->read($perguntas[$index]['id']);
        $resultado .= '<dl class="row">';
        $resultado .= '<dt class="col-sm-3"> Pergunta</dt>';
        $resultado .= '<dd class="col-sm=9">'.$perguntas[$index]['pergunta'];
        $resultado .= '<input type="hidden" name="pergunta" id="pergunta" value="'.$perguntas[$index]['id'].'">';
        $resultado .= '</dl>';

        foreach($resposta as $r):
        $resultado .= '<dl class="row">';
        $resultado .= '<dd class="col-sm=9"><input type="checkbox" id="resposta_selecionada" name="resposta_selecionada" value='.$r['id'].'> '.$r['resposta'];
        $resultado .= '</dl>';
        endforeach;
        $resultado .= '<dd class="modal-footer">';
        $resultado .= ' <button type="button" name= "selecionar" id="'.$_POST['pesquisa_id'].'" class="btn btn-primary proxima_pergunta">Proxima pergunta</button>';
        $resultado .= ' <a href="../../../../pesquisa-fechada.php?pesquisa-fechada.php&email='.$_POST['email_usuario'].'" class="btn btn-secondary">Fechar</a>';
        $resultado .= '</dd>';
        echo $resultado;
    }else{
        require '../../Model/EnviarPesquisaDao.php';

        $enviar_pesquisaDao = new \App\Model\EnviarPesquisaDao();
        $enviar_pesquisaDao->update($_POST['email_usuario'], $_POST['pesquisa_id']);

        $resultado .= '<div class="alert alert-success" role="alert">';
        $resultado .= 'Obrigado por responder este questionario. Clique em Fechar para responder mais questionários!</div>';
        $resultado .= '<dd class="modal-footer">';
        $resultado .= '<a href="../../../../pesquisa-fechada.php?pesquisa-fechada.php&email='.$_POST['email_usuario'].'" class="btn btn-secondary">Fechar</a>';
        $resultado .= '</dd>';

        echo $resultado;
    }
}


?>