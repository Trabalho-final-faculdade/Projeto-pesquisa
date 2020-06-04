<?php

session_start();
    
require '../../Model/Conexao.php';
require '../../Model/Pesquisa.php';
require '../../Model/PesquisaDao.php';
require '../../Model/PerguntaDao.php';
require '../../Model/RespostaDao.php';
require '../../Model/QuestionarioDao.php';
require '../../Model/Questionario.php';
require '../../Model/EscalaPerguntaDao.php';

$questionarioDao = new \App\Model\QuestionarioDao();
$escalaDao = new \App\Model\EscalaPerguntaDao();
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

if(isset($_POST['pergunta']) && $_POST['pergunta'] != '' 
    && isset($_POST['id_usuario']) && $_POST['id_usuario'] != ''){

        $questionario = new \App\Model\Questionario();
        
        if($_POST['array_escala_matriz']){
            foreach($_POST['array_escala_matriz'] as $respostas_matriz){
                
                $questionario->setEscalaId(addslashes($respostas_matriz[1]));
                $questionario->setEntrevistadoEmail(addslashes($_SESSION['email_usuario']));
                $questionario->setPerguntaId(addslashes($_POST['pergunta']));
                $questionario->setRespostaId(addslashes($respostas_matriz[0]));
                $questionario->setPesquisaId(addslashes($pesquisa_selecionada));
                $questionario->setOperadorId(addslashes($_POST['id_usuario']));
                $questionario->setConcluido(addslashes(0));
                $questionarioDao->create($questionario);
             
            }
            
       
        }else if($_POST['array_respostas']){
            
            foreach($_POST['array_respostas'] as $resposta){
                $questionario->setRespostaId(addslashes($resposta));
                $questionario->setEntrevistadoEmail(addslashes($_SESSION['email_usuario']));
                $questionario->setPerguntaId(addslashes($_POST['pergunta']));
                $questionario->setPesquisaId(addslashes($pesquisa_selecionada));
                $questionario->setOperadorId(addslashes($_POST['id_usuario']));
                $questionario->setConcluido(addslashes(0));
                $questionarioDao->create($questionario);
            };
        }else{
            $questionario->setRespostaId(addslashes($_POST['resposta_selecionada']));
            $questionario->setEntrevistadoEmail(addslashes($_SESSION['email_usuario']));
            $questionario->setPerguntaId(addslashes($_POST['pergunta']));
            $questionario->setPesquisaId(addslashes($pesquisa_selecionada));
            $questionario->setOperadorId(addslashes($_POST['id_usuario']));
            $questionario->setConcluido(addslashes(0));
            $questionarioDao->create($questionario);
        }
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
    $contador = false;
    
    $respondeu_questionario = $questionarioDao->verifica_usuario_ja_respondeu_questionario($pesquisa_selecionada, $_SESSION['email_usuario']);
    if($respondeu_questionario == false){
        $perguntas = $rd->buscar_pergunta_pesquisa($pesquisa_selecionada);
        //Exibe a pergunta e as respostas
        do{
            $pergunta = $questionarioDao->verifica_usuario_ja_respondeu_pergunta($perguntas[$index]['id'], $_SESSION['email_usuario']);
            if($pergunta == true)
                $index++;
            
        }while($pergunta == true);
        if(isset($perguntas[$index]['id']) && !empty($perguntas[$index]['id'])){
            $resposta = $r->read($perguntas[$index]['id']);
            
            $_SESSION['pesquisa_selecionada'] = $pesquisa_selecionada;

            $resultado .= '<input type="hidden" value="'.$_SESSION['pesquisa_selecionada'].'" id="pesquisa_selecionada" />';
            $resultado .= '<dl class="row">';
            $resultado .= '<dt class="col-sm-3"> Pergunta</dt>';
            $resultado .= '<dd class="col-sm=9">'.$perguntas[$index]['pergunta'];
            $resultado .= '<input type="hidden" name="pergunta" id="pergunta" value="'.$perguntas[$index]['id'].'">';
            $resultado .= '</dl>';
            
            if($perguntas[$index]['tipo'] == 'resposta_unica'){
                foreach($resposta as $r): 
                    $resultado .= '<table>';
                    $resultado .=     '<tr>';
                    $resultado .= '     <td class="col-sm=9"><input type="radio" id="resposta_selecionada" name="resposta_selecionada" value='.$r['id'].'> '.$r['resposta'].'</input></td>'; 
                    $resultado .=     '</tr>';
                    $resultado .= '</table>';
                endforeach;   
            }else if($perguntas[$index]['tipo'] == 'multipla_escolha'){
                foreach($resposta as $r): 
                    $resultado .= '<table>';
                    $resultado .=     '<tr>';
                    $resultado .= '       <td class="col-sm=9"><input type="checkbox" id="resposta_selecionada" name="resposta_selecionada[]" value='.$r['id'].'> '.$r['resposta'].'</td>';
                    $resultado .=     '</tr>';
                    $resultado .= '</table>';
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
            $resultado .= ' <button type="button" name= "selecionar" id="'.$_POST['pesquisa_id'].'" class="btn btn-primary proxima_pergunta">Próxima pergunta</button>';
            $resultado .= ' <a href="" class="btn btn-secondary">Fechar</a>';
            $resultado .= '</dd>';
            echo $resultado;

        // Caso nao tenha mais perguntas, cai neste else para exibir para o usuario que acabou.
        }else{
            $index--;
  
            if(empty($questionario)){
                $questionarioDao->concluir_pesquisa($pesquisa_selecionada, $_SESSION['email_usuario'], $perguntas[$index]['id']);
            }else{
                $questionarioDao->concluir_pesquisa($questionario->getPesquisaId(), $questionario->getEntrevistadoEmail(), $questionario->getPerguntaId());       
            }
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