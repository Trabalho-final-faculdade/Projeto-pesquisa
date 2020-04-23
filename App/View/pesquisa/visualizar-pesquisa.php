<?php

require_once '../../../vendor/autoload.php';
require_once '../../Model/Nivel_de_acessoDao.php';
header('Content-type: text/html; charset=utf-8');    

include_once '../../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$p = new \App\Model\Pesquisa();
$pd = new \App\Model\PesquisaDao();
$pergunta = new \App\Model\Pergunta();
$perguntaDao = new \App\Model\PerguntaDao();
$respostas = new \App\Model\Resposta();
$respostasDao = new \App\Model\RespostaDao();
$i = 0;
$resultado_perguntas = $perguntaDao->buscar_pergunta_pesquisa($_GET['id']);

$resultado = $pd->read($_GET['id']);
$p->setId(addslashes($resultado[0]['id']));
$p->setTitulo(addslashes($resultado[0]['titulo']));
$p->setDataFinal(addslashes($resultado[0]['data_final']));
$p->setDataInicial(addslashes($resultado[0]['data_inicial']));
$p->setObservacao(addslashes($resultado[0]['observacao']));

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;
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
                <h3>Visualização da pesquisa</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <form method="POST" name="frm_campo_dinamico" action="../Controller/pergunta_controller/cadastrar-pergunta-resposta.php">
                          <div class="x_title">
                                <h2>Dados da pesquisa.</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="pesquisa">Pergunta relacionada a pesquisa: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="hidden" id="pesquisa" name="pesquisa" minlength="5" value="<?php echo $p->getId()?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">  
                                  <input type="text" id="" disabled="true" name="" minlength="5" value="<?php echo $p->getTitulo()?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="data_inicial">Data inicial da pesquisa: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="date" id="data_inicial" disabled="true" name="data_inicial" class="date-picker form-control" required="required" value="<?php echo $p->getDataInicial()?>">
                                </div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="data_final">Data final da pesquisa: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="date" id="data_final" disabled="true" name="data_final" class="date-picker form-control" required="required" value="<?php echo $p->getDataFinal()?>">                            </div>
                                </div>
                            </div>
                            <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="pesquisa">Observação: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="text" id="" disabled="true" name="" minlength="5" value="<?php echo $p->getObservacao()?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            </br>
                            <div class="x_title">
                                <h2>Perguntas relacionadas.</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            </br>
                            <?php foreach($resultado_perguntas as $questionario):?>
                              <?php $i += 1 ?>
                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <h4 class="panel-title"><?php echo utf8_encode($questionario['pergunta']) ?></h4>
                                    </a>
                                    <div id="collapseOne<?php echo $i ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                    <th>Respostas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($respostasDao->read($questionario['id']) as $resposta):?>
                                                    <tr>
                                                    <th scope="row">1</th>
                                                    <td><?php echo utf8_encode($resposta['resposta']);?></td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <?php endforeach;?>
                        </form>
                   </div>
                </div>
            </div>
        </div>
   <?php 
   
   include_once '../../includes/rodape_pagina.php';
   
   ?>
    <!-- /footer content -->
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
