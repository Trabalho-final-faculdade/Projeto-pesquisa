<?php 
require_once 'vendor/autoload.php';

session_start();

$peguntaDao = new \App\Model\PerguntaDao();
$rd = new \App\Model\RespostaDao();
$escalas = new \App\Model\EscalaPerguntaDao();
use Dompdf\Dompdf;

$dompdf = new DOMPDF();

$perguntas_respostas = $peguntaDao->buscar_pergunta_pesquisa($_POST['dados_pesquisa_pesquisa_id']);
 
if(isset($_POST['dados_pesquisa_finalizadas'])){
  $pesquisa_finalizada = $_POST['dados_pesquisa_finalizadas'];
} else{
  $pesquisa_finalizada = 0;
} 

$html .= '<html><body>';
$html .= '<h2>Dados estatísticos da pesquisa</h2>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse;">';
$html .= '<tbody>';
$html .=    '<tr>';
$html .=      '<td>Título da pesquisa</td>';
$html .=      '<td> '.$_POST['dados_pesquisa_titulo'].' </td>';
$html .=    '</tr>';
$html .=    '<tr>';
$html .=      '<td>Observação</td>';
$html .=      '<td> '.$_POST['dados_pesquisa_observacao'].' </td>';
$html .=    '</tr>';

$html .=    '<tr>';
$html .=      '<td>Data de criação</td>';
$html .=      '<td> '.date('d/m/Y', strtotime($_POST['dados_pesquisa_criada_em'])).' </td>';
$html .=    '</tr>';

$html .=    '<tr>';
$html .=      '<td>Pesquisas finalizadas</td>';
$html .=      '<td> '.$pesquisa_finalizada.' </td>';
$html .=    '</tr>';

$html .= '</tbody>';
$html .= '<h2>Dados estatísticos das perguntas</h2>';





foreach($perguntas_respostas as $pergunta): 
  
   if($pergunta['tipo'] != 'matriz'){ 
      $html .= '<div><table class="bordered striped centered">';
      $html .=   '<thead>';
      $html .=     '<tr>';
      $html .=       '<th>Pergunta '.++$count.'</th>';
      $html .=       '<th>'.$pergunta['pergunta'].'</th>';
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
      
    $html .=   '<div><table>';
    $html .=     '<tr>';
    $html .=       '<th>Pergunta '.++$count.'</th>';
    $html .=      '<th>'.$pergunta['pergunta'].'</th>';
    $html .=     '</tr>';

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
    $html .= '</table></div>';
   }

endforeach;

$html .= '</body></html>';
//echo $html;
//exit();     
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
ob_end_clean();
$dompdf->stream(
  "relatorio_teste.pdf",
  array(
    "Attachment" => false,
  )
);