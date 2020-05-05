<?php

session_start();
    
require '../../Model/Conexao.php';
require '../../Model/Pesquisa.php';
require '../../Model/PesquisaDao.php';
require '../../Model/PerguntaDao.php';
require '../../Model/RespostaDao.php';
require '../../Model/QuestionarioDao.php';

$pd = new \App\Model\PesquisaDao();
$r = new \App\Model\RespostaDao();
$p = new \App\Model\Pesquisa();
$resultado = '';

$pesquisa_selecionada = $_POST['pesquisa_id'];

if(isset($_POST['index'])){
    $index = $_POST['index'];
}else{
    $index = 0;
}    

if(isset($_POST['resposta_selecionada']) && $_POST['resposta_selecionada'] != '' 
    && isset($_POST['pergunta']) && $_POST['pergunta'] != '' 
    && isset($_POST['id_usuario']) && $_POST['id_usuario'] != ''){
        require '../../Model/Questionario.php';

        $questionario = new \App\Model\Questionario();
        $questionarioDao = new \App\Model\QuestionarioDao();

        $questionario->setEntrevistadoEmail(addslashes($_SESSION['email_usuario']));
        $questionario->setRespostaId(addslashes($_POST['resposta_selecionada']));
        $questionario->setPerguntaId(addslashes($_POST['pergunta']));
        $questionario->setPesquisaId(addslashes($pesquisa_selecionada));
        $questionario->setOperadorId(addslashes($_POST['id_usuario']));
        $questionarioDao->create($questionario);
}

// Exibe pesquisas dispoíveis
if(isset($_POST['email_usuario']) && $_POST['email_usuario'] != ''){
    $pesquisas = $pd->buscar_pesquisas_estado_aberta("em andamento");
    if(isset($_POST['email_usuario']) && !empty($_POST['email_usuario'])){
        $_SESSION['email_usuario'] = $_POST['email_usuario'];
    }

    if(isset($pesquisas) && !empty($pesquisas)){
        $resultado .= '<dl class="row">';
        $resultado .= '<dt class="col-sm-9">Selecione uma das pesquisas disponiveis</dt>';
        $resultado .= '<dd class="col-sm=9">';     
        $resultado .= '<select name="select" multiple class="form-control" id="select_pesquisa">';
        foreach($pesquisas as $pesquisa):
            $resultado .= '<option value="'.$pesquisa['id'].'">'.$pesquisa['titulo'].'</option>';
        endforeach;
        $resultado .= '</select>';
        
        $resultado .= '<dd class="modal-footer">';
        $resultado .= ' <button type="button" name= "selecionar_pesquisa" id="'.$_POST['pesquisa_id'].'" class="btn btn-primary iniciar_pesquisa">Iniciar pesquisa</button>';
        $resultado .= ' <a href="" class="btn btn-secondary">Fechar</a>';
        $resultado .= '</dd>';
        $_SESSION['email_usuario'] = $_POST['email_usuario'];        
        echo $resultado;
   
    }else{
    echo "Nenhuma pesquisa encontrada";
    }
//Logo após selecionar uma pesquisa
}else if(isset($pesquisa_selecionada) && $pesquisa_selecionada != ''){
    $rd = new \App\Model\PerguntaDao();
    $questionarioDao = new \App\Model\QuestionarioDao();
    $respondeu = $questionarioDao->verifica_usuario_ja_respondeu($pesquisa_selecionada, $_SESSION['email_usuario']);
    if($respondeu == false){
        $perguntas = $rd->buscar_pergunta_pesquisa($pesquisa_selecionada);
        //Exibe a pergunta e as respostas
        if(isset($perguntas[$index]['id']) && !empty($perguntas[$index]['id'])){
            $resposta = $r->read($perguntas[$index]['id']);
            $_SESSION['pesquisa_selecionada'] = $pesquisa_selecionada;

            $resultado .= '<input type="hidden" value="'.$_SESSION['pesquisa_selecionada'].'" id="pesquisa_selecionada" />';
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
            $resultado .= ' <button type="button" name= "selecionar" id="'.$_POST['pesquisa_id'].'" class="btn btn-primary proxima_pergunta">Próxima pergunta</button>';
            $resultado .= ' <a href="" class="btn btn-secondary">Fechar</a>';
            $resultado .= '</dd>';

            echo $resultado;
      
        // Caso nao tenha mais perguntas, cai neste else para exibir para o usuario que acabou.
        }else{
            require '../../Model/EnviarPesquisaDao.php';

            $enviar_pesquisaDao = new \App\Model\EnviarPesquisaDao();
            $enviar_pesquisaDao->update($_POST['email_usuario'], $_POST['pesquisa_id']);

            $resultado .= '<div class="alert alert-success" role="alert">';
            $resultado .= 'Obrigado por responder este questionario. Clique em Fechar para responder mais questionários!</div>';
            $resultado .= '<dd class="modal-footer">';
            $resultado .= '<a href="" class="btn btn-secondary">Fechar</a>';
            $resultado .= '</dd>';

            echo $resultado;   
        }
    }else{
        echo "Email ja respondeu esta pesquisa";
        $resultado .= '<dd class="modal-footer">';
        $resultado .= ' <a href="" class="btn btn-secondary">Retornar</a>';
        $resultado .= '</dd>';

        echo $resultado;
    }
    
}else{
  echo "errro";
  }
?>