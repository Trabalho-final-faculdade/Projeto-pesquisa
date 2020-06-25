<?php

use App\Model\QuestionarioDao;

session_start();

if(isset($_POST['pesquisa_id']) && $_POST['pesquisa_id'] != ''){
    
    require '../../Model/Conexao.php';
    require '../../Model/PerguntaDao.php';
    require '../../Model/RespostaDao.php';
    require '../../Model/Questionario.php';
    require '../../Model/QuestionarioDao.php';
    require '../../Model/EscalaPerguntaDao.php';

    $questionario = new \App\Model\Questionario();
    $questionarioDao = new \App\Model\QuestionarioDao();
    $escalaDao = new \App\Model\EscalaPerguntaDao();
    $r = new \App\Model\RespostaDao();
    $rd = new \App\Model\PerguntaDao();
    $resultado = '';
    if(isset($_POST['index'])){
        $index = $_POST['index'];
    }else{
        $index = 0;
    }

    if(isset($_POST['pergunta']) && $_POST['pergunta'] != '' 
    && isset($_POST['id_usuario']) && $_POST['id_usuario'] != ''){

        if(count($_POST['array_escala_matriz']) > 0){
            foreach($_POST['array_escala_matriz'] as $respostas_matriz){
                
                $questionario->setEscalaId(addslashes($respostas_matriz));
                $questionario->setRespostaId(addslashes($_POST['resposta']));
                $questionario->setEntrevistadoEmail(addslashes($_POST['email_usuario']));
                $questionario->setPerguntaId(addslashes($_POST['pergunta']));
                $questionario->setPesquisaId(addslashes($_POST['pesquisa_id']));
                $questionario->setOperadorId(addslashes(81));
                $questionario->setConcluido(addslashes(0));
                $questionarioDao->create($questionario);   
             
            }
        
        }else if(count($_POST['array_respostas']) > 0){
            
            foreach($_POST['array_respostas'] as $resposta){
                $questionario->setRespostaId(addslashes($resposta));
                $questionario->setEntrevistadoEmail(addslashes($_POST['email_usuario']));
                $questionario->setPerguntaId(addslashes($_POST['pergunta']));
                $questionario->setPesquisaId(addslashes($_POST['pesquisa_id']));
                $questionario->setOperadorId(addslashes(81));
                $questionario->setConcluido(addslashes(0));
                $questionarioDao->create($questionario);
            };
    
        }else{
            $questionario->setEntrevistadoEmail(addslashes($_POST['email_usuario']));
            $questionario->setRespostaId(addslashes($_POST['resposta_selecionada']));
            $questionario->setPerguntaId(addslashes($_POST['pergunta']));
            $questionario->setPesquisaId(addslashes($_POST['pesquisa_id']));
            $questionario->setOperadorId(81);
            $questionario->setConcluido(0);
            $questionarioDao->create($questionario);
        
        }
    }
    
    $perguntas = $rd->buscar_pergunta_pesquisa($_POST['pesquisa_id']);
    do{
        $pergunta_respondida = $questionarioDao->verifica_usuario_ja_respondeu_pergunta($perguntas[$index]['id'], $_POST['email_usuario']);
           if($pergunta_respondida == true)
              $index++;
        
    }while($pergunta_respondida == true);
   
    if(isset($perguntas[$index]['id']) && !empty($perguntas[$index]['id'])){
        $resposta = $r->read($perguntas[$index]['id']);
        $resultado .= '<dl class="row">';
        $resultado .= '<dt class="col-sm-3"> Pergunta</dt>';
        $resultado .= '<dd class="col-sm=9">'.$perguntas[$index]['pergunta'];
        $resultado .= '<input type="hidden" name="pergunta" id="pergunta" value="'.$perguntas[$index]['id'].'">';
        $resultado .= '</dl>';
        if($perguntas[$index]['tipo'] == 'resposta_unica'){
            foreach($resposta as $r):
                $resultado .= '<dl class="row">';
                $resultado .= '<dd class="col-sm=9"><input type="radio" id="resposta_selecionada" name="resposta_selecionada[]" value='.$r['id'].'> '.$r['resposta'];
                $resultado .= '</dl>';
            endforeach;        
        }else if($perguntas[$index]['tipo'] == 'multipla_escolha'){
            foreach($resposta as $r):
            $resultado .= '<dl class="row">';
            $resultado .= '<dd class="col-sm=9"><input type="checkbox" id="resposta_selecionada" name="resposta_selecionada" value='.$r['id'].'> '.$r['resposta'];
            $resultado .= '</dl>';
            endforeach;
        }else if($perguntas[$index]['tipo'] == 'matriz'){
            $escalas = $escalaDao->read($perguntas[$index]['id']);
            $resultado .= '<table border="2" cellspacing="10">';
            $resultado .=     '<tr>';
            $resultado .=        '<th></th>';    
                            foreach($escalas as $escala):
            $resultado .=            '<th>'.$escala['escala_descricao'].'</th>';
                            endforeach;
            $resultado .=    '</tr>';
                    foreach($resposta as $r): 
            $resultado .=    '<tr>';
            $resultado .=         '<td>'.$r['resposta'].'</td>';
                                foreach($escalas as $escala):
            $resultado .=            '<td><input type="radio" name='.$r['id'].' value='.$escala['id'].' onclick="adicionaResposta(this, '.$r['id'].')"> </input></td>';
                                endforeach;

            $resultado .=    '</tr>';
                    endforeach;            
            $resultado .= '</table>';
        }
        $resultado .= '<dd class="modal-footer">';
        $resultado .= ' <button type="button" name= "selecionar" id="'.$_POST['pesquisa_id'].'" class="btn btn-primary proxima_pergunta">Proxima pergunta</button>';
        $resultado .= ' <a href="../../../../pesquisa-fechada.php?pesquisa-fechada.php&email='.$_POST['email_usuario'].'" class="btn btn-secondary">Fechar</a>';
        $resultado .= '</dd>';

        echo $resultado;
    }else{
        require '../../Model/EnviarPesquisaDao.php';

        $enviar_pesquisaDao = new \App\Model\EnviarPesquisaDao();
        $enviar_pesquisaDao->update($_POST['email_usuario'], $_POST['pesquisa_id']);
        $index--;
  
        if(!empty($questionario->getPesquisaId())){
            $questionarioDao->concluir_pesquisa($questionario->getPesquisaId(), $questionario->getEntrevistadoEmail(), $questionario->getPerguntaId());       
        }else{
            $questionarioDao->concluir_pesquisa($_POST['pesquisa_id'], $_POST['email_usuario'], $perguntas[$index]['id']);
        }        

        $resultado .= '<div class="alert alert-success" role="alert">';
        $resultado .= 'Obrigado por responder este questionario. Clique em Fechar para responder mais questionários!</div>';
        $resultado .= '<dd class="modal-footer">';
        $resultado .= '<a href="../../../../pesquisa-fechada.php?pesquisa-fechada.php&email='.$_POST['email_usuario'].'" class="btn btn-secondary">Fechar</a>';
        $resultado .= '</dd>';

        echo $resultado;
    }
}


?>