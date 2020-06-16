<?php 
require_once 'vendor/autoload.php';

session_start();

$peguntaDao = new \App\Model\PerguntaDao();
$rd = new \App\Model\RespostaDao();
$escalas = new \App\Model\EscalaPerguntaDao();

$perguntas_respostas = $peguntaDao->buscar_pergunta_pesquisa($_POST['dados_pesquisa_pesquisa_id']);
 
if(isset($_POST['dados_pesquisa_finalizadas'])){
  $pesquisa_finalizada = $_POST['dados_pesquisa_finalizadas'];
} else{
  $pesquisa_finalizada = 0;
} 

?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Contato</title>
  </head>
  <body>
    <?php  
      $arquivo = 'pesquisa.xls';

      $html .= '<table width="100%">';
      $html .= '<thead>';
      $html .=    '<tr>';
      $html .=      '<th colspan="4">Dados estatísticos da pesquisa</th>';
      $html .=    '</tr>';
      $html .= '</thead>';
      $html .= '<tbody>';
      $html .=    '<tr>';
      $html .=      '<td colspan="2">Título da pesquisa</td>';
      $html .=      '<td colspan="4"> '.$_POST['dados_pesquisa_titulo'].' </td>';
      $html .=    '</tr>';
      $html .=    '<tr>';
      $html .=      '<td colspan="2">Observação</td>';
      $html .=      '<td colspan="4"> '.$_POST['dados_pesquisa_observacao'].' </td>';
      $html .=    '</tr>';

      $html .=    '<tr>';
      $html .=      '<td colspan="2">Data de criação</td>';
      $html .=      '<td> '.date('d/m/Y', strtotime($_POST['dados_pesquisa_criada_em'])).' </td>';
      $html .=    '</tr>';

      $html .=    '<tr>';
      $html .=      '<td colspan="2">Pesquisas finalizadas</td>';
      $html .=      '<td> '.$pesquisa_finalizada.' </td>';
      $html .=    '</tr>';
      $html .=    '<tr>';
      $html .=      '<td colspan="4"><center><strong>Dados estatísticos das perguntas </strong></center></td>';
      $html .=    '</tr>';
      foreach($perguntas_respostas as $pergunta): 
  
        if($pergunta['tipo'] != 'matriz'){ 
      
          $html .=     '<tr>';
          $html .=       '<th>Pergunta '.++$count.'</th>';
          $html .=       '<th colspan="5">'.$pergunta['pergunta'].'</th>';
          $html .=     '</tr>';
          $respostas = $rd->read($pergunta['id']); 
          foreach($respostas as $resposta):
              $votos_por_resposta = $rd->resultado_por_resposta($resposta['id']); 
                if(isset($votos_por_resposta) && !empty($votos_por_resposta)){        
                   $html .=      '<tr>';                             
                   $html .=         '<td colspan="5">Resposta: '.$votos_por_resposta[0]['resposta']." Votos: ".$votos_por_resposta[0]['quantidade'].'</td>';
                }else{ 
                   $html .=         '<td colspan="5">Resposta: '.$resposta['resposta'].' Votos: 0</td>';
                }
                   $html .=      '</tr>';
          endforeach;                
        }else{  
                           
          $todas_escalas = $escalas->read($pergunta['id']);
            
         
          $html .=     '<tr>';
          $html .=         '<th>Pergunta '.++$count.'</th>';
          $html .=         '<th colspan="5">'.$pergunta['pergunta'].'</th>';
          $html .=     '</tr>';
    
          foreach($rd->read($pergunta['id']) as $r):  
            $html .=   '<tr>';
            $html .=     '<td colspan="5">'.$r['resposta'].'</td>';
            $votos_por_resposta = $escalas->resultado_por_resposta($pergunta['id'], $r['id']);
            foreach($votos_por_resposta as $votos): 
                 
               $html .= ' <td colspan="3">'.$votos['escala_descricao'].'  teve '.$votos['quantidade'].' votos</td>';
                  
               if(empty($votos_por_resposta)){ 
                  $html .= '<td colspan="3">'.$escala['escala_descricao'].' Votos: 0</td>';
                } 
            endforeach;
            $html .=   '</tr>';
          endforeach; 
        }  
      endforeach;
      $html .= '</tbody>';
      

      foreach($perguntas_respostas as $pergunta): 
  
        if($pergunta['tipo'] != 'matriz'){ 
      
      
           $html .= '<table width="100%">';
           $html .=  '<thead>';
           $html .=     '<tr>';
           $html .=       '<th>Pergunta '.++$count.'</th>';
           $html .=       '<th colspan="5">'.$pergunta['pergunta'].'</th>';
           $html .=     '</tr>';
           $html .=  '</thead>';
           $html .=   '<tbody>'; 
           $respostas = $rd->read($pergunta['id']); 
             foreach($respostas as $resposta):
                 $votos_por_resposta = $rd->resultado_por_resposta($resposta['id']); 
                 if(isset($votos_por_resposta) && !empty($votos_por_resposta)){        
           $html .=      '<tr>';                             
           $html .=         '<td>Resposta: '.$votos_por_resposta[0]['resposta']." Votos: ".$votos_por_resposta[0]['quantidade'].'</td>';
                 }else{ 
           $html .=         '<td>Resposta: '.$resposta['resposta'].' Votos: 0</td>';
                 }
           $html .=      '</tr>';
                 endforeach;                              
           $html .=   '</tbody>';
           $html .= '</table></div>';
      
      
      
       }else{  
                           
         $todas_escalas = $escalas->read($pergunta['id']);
           
         $html .= '<table width="100%">';
         $html .=  '<thead>';
         $html .=     '<tr>';
         $html .=         '<th>Pergunta '.++$count.'</th>';
         $html .=         '<th>'.$pergunta['pergunta'].'</th>';
         $html .=     '</tr>';
         $html .=  '</thead>';
         $html .=  '<tbody>';
         foreach($rd->read($pergunta['id']) as $r):  
           $html .=   '<tr>';
           $html .=     '<td>'.$r['resposta'].'</td>';
           $votos_por_resposta = $escalas->resultado_por_resposta($pergunta['id'], $r['id']);
           foreach($votos_por_resposta as $votos): 
                
              $html .= ' <td>'.$votos['escala_descricao'].'  teve '.$votos['quantidade'].' votos</td>';
                 
              if(empty($votos_por_resposta)){ 
                 $html .= '<td>'.$escala['escala_descricao'].' Votos: 0</td>';
               } 
           endforeach;
           $html .=   '</tr>';
         endforeach;   
         $html .=  '</tbody>';
         $html .= '</table>';
        }
      
      endforeach;

      header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
      header ("Cache-Control: no-cache, must-revalidate");
      header ("Pragma: no-cache");
      header ("Content-type: application/x-msexcel");
      header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
      header ("Content-Description: PHP Generated Data" );
      // Envia o conteúdo do arquivo
      echo $html;
      exit; ?>

    
  </body>
</html>
