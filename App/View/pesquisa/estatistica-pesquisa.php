<?php

require_once '../../../vendor/autoload.php';

include_once '../../includes/header.php';
include_once '../../Model/Nivel_de_acessoDao.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}
$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$peguntaDao = new \App\Model\PerguntaDao();
$questionarioDao = new \App\Model\QuestionarioDao();
$escalas = new \App\Model\EscalaPerguntaDao();
foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;
$pd = new \App\Model\PesquisaDao(); 
$rd = new \App\Model\RespostaDao();

$dados_pesquisa = $pd->read($_GET['id']);
$finalizadas = $pd->buscar_finalizadas($_GET['id']);
$perguntas_respostas = $peguntaDao->buscar_pergunta_pesquisa($_GET['id']);
?>
<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <?php 
          include_once '../../includes/imagem_empresa.php';   
          include_once '../../includes/left_menu.php';    
          include_once '../../includes/menu_top.php';    
        ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Dados estatísticos</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dados estatísticos da pesquisa</h2>
                    <form action="../../../relatorio_pdf.php" method="post">
                      <center><button type="submit" name="btn_pdf" id="btn_pdf" class="btn btn-primary">Gerar PDF</button></center>
                      <input type="hidden" name="dados_pesquisa_titulo" value="<?php echo $dados_pesquisa[0]['titulo'] ?>">
                      <input type="hidden" name="dados_pesquisa_observacao" value="<?php echo $dados_pesquisa[0]['observacao'] ?>">
                      <input type="hidden" name="dados_pesquisa_criada_em" value="<?php echo $dados_pesquisa[0]['criada_em'] ?>"> 
                      <input type="hidden" name="dados_pesquisa_data_inicial" value="<?php echo $dados_pesquisa[0]['data_inicial'] ?>">
                      <input type="hidden" name="dados_pesquisa_data_final" value="<?php echo $dados_pesquisa[0]['data_final'] ?>">
                      <input type="hidden" name="dados_pesquisa_finalizadas" value="<?php echo count($finalizadas) ?>">
                      <input type="hidden" name="dados_pesquisa_pesquisa_id" value="<?php echo $_GET['id'] ?>">
                    </form>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Título da pesquisa</td>
                                    <td><?php echo $dados_pesquisa[0]['titulo'] ?></td>
                                </tr>
                                <tr>
                                    <td>Observação</td>
                                    <td><?php echo $dados_pesquisa[0]['observacao'] ?></td>
                                </tr>
                                <tr>
                                    <td>Data de criação</td>
                                    <td><?php echo date('d/m/Y', strtotime($dados_pesquisa[0]['criada_em'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Data de início</td>
                                    <td><?php echo date('d/m/Y', strtotime($dados_pesquisa[0]['data_inicial'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Data de término</td>
                                    <td><?php echo date('d/m/Y', strtotime($dados_pesquisa[0]['data_final'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Pesquisas finalizadas </td>
                                    <td><?php 
                                        if(isset($finalizadas)){
                                          echo count($finalizadas);
                                        } else{
                                          echo "0";
                                        } 
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="">
                    <h2>Dados estatísticos das perguntas</h2>
                  
                  </div></br>
                  <div class="container">
                  <?php $count = 1; 
                    foreach($perguntas_respostas as $pergunta): ?>
                    <?php if($pergunta['tipo'] != 'matriz'){ ?>
                      <table>
                          <thead>
                            <tr>
                                <th>Pergunta <?php echo $count++?></th>
                                <th><?php echo $pergunta['pergunta'] ?></th>
                            </tr>
                          </thead>
                          <tbody> 
                              <?php $respostas = $rd->read($pergunta['id']); 
                                foreach($respostas as $resposta):
                                  $votos_por_resposta = $rd->resultado_por_resposta($resposta['id']); 
                                  if(isset($votos_por_resposta) && !empty($votos_por_resposta)){ ?>       
                                  <tr>                             
                                    <td>Resposta: <?php echo $votos_por_resposta[0]['resposta'] ?></td>
                                    <td>Votos: <?php echo $votos_por_resposta[0]['quantidade'] ?></td>
                                  <?php }else{ ?>
                                    <td>Resposta: <?php echo $resposta['resposta'] ?></td>
                                    <td>Votos: 0</td>
                                  <?php } ?>
                                  </tr>
                                <?php endforeach;                              
                              ?>
                          </tbody>
                      </table></br>
                      <?php }else{  
                        
                        $todas_escalas = $escalas->read($pergunta['id']); ?>

                        <table>
                          <thead>
                            <tr>
                              <th>Pergunta <?php echo $count++?></th>
                              <th><?php echo $pergunta['pergunta'] ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($rd->read($pergunta['id']) as $r): ?> 
                              <tr>
                                  <td><?php echo $r['resposta'] ?></td>
                                  
                                  <?php $votos_por_resposta = $escalas->resultado_por_resposta($pergunta['id'], $r['id']); ?>
                                    <?php foreach($votos_por_resposta as $votos):  ?>

                                        <td><?php echo $votos['escala_descricao']."  teve ".$votos['quantidade']." votos" ?></td>

                                     <?php endforeach; ?>

                                  <td><?php if(empty($votos_por_resposta)){ 

                                  echo $escala['escala_descricao']." Votos: 0" ?></td>
                                  
                                <?php } ?>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>  
                        </table></br>
                     <?php }
                     endforeach; ?>     
                  </div>
              </div>
            </div>
        </div>
      <?php  
        include_once '../../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
