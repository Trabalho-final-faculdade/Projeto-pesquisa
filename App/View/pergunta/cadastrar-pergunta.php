<?php

require_once '../../vendor/autoload.php';
require_once '../Model/Nivel_de_acessoDao.php';


include_once '../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$pergunta = new \App\Model\Pergunta();
$perguntaDao = new \App\Model\PerguntaDao();
$p = new \App\Model\Pesquisa();
$pd = new \App\Model\PesquisaDao();
$respostas = new \App\Model\Resposta();
$respostasDao = new \App\Model\RespostaDao();

$resultado_perguntas = $perguntaDao->buscar_pergunta_pesquisa($_GET['id']);

$resultado = $pd->read($_GET['id']);
$p->setId(addslashes($resultado[0]['id']));
$p->setDataInicial(addslashes($resultado[0]['data_inicial']));
$p->setDataFinal(addslashes($resultado[0]['data_final']));
$p->setObservacao(addslashes($resultado[0]['observacao']));
$p->setTitulo(addslashes($resultado[0]['titulo']));
$p->setStatus(addslashes($resultado[0]['status']));

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;
?>
<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <?php 
            include_once '../includes/imagem_empresa.php';        
     
            include_once '../includes/left_menu.php';        
      
            include_once '../includes/menu_top.php';
       ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cadastro pergunta</h3>
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
            </style>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
            <script type="text/javascript">
              $(function () {
                function removeCampo() {
                $(".removerCampo").unbind("click");
                $(".removerCampo").bind("click", function () {
                  if($("tr.linhas").length > 1){
                  $(this).parent().parent().remove();
                  }
                });
                }
              
                $(".adicionarCampo").click(function () {
                novoCampo = $("tr.linhas:first").clone();
                novoCampo.find("input").val("");
                novoCampo.insertAfter("tr.linhas:last");
                removeCampo();
                });
              });
            </script>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <form method="POST" name="frm_campo_dinamico" action="../Controller/pergunta_controller/cadastrar-pergunta-resposta.php">
                          <div class="x_title">
                                <h2>Cadastrar pergunta.</h2>
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
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="pergunta">Pergunta: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="text" id="pergunta" name="pergunta" minlength="5" value="" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="genero">Tipo de pergunta <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                <select name="tipo_pergunta" id="select" class="form-control" required="required">
                                  <option value="">Selecione</option>
                                  <option value="dicotonica">Dicotônica</option>
                                  <option value="matriz">Matriz</option>
                                  <option value="multipla_escolha">Múltiplia escolha</option>
                                  <option value="resposta_unica">Resposta única</option>
                                </select>
                              </div>
                            </div>
                        
                          <div id="tudo">
                            <table cellpadding="4" cellspacing="6">
                              <tr><td colspan="4" class="bd_titulo">Cadastrar respostas</td></tr>                          
                              <tr>
                                <td class="bd_titulo">Respostas</td>
                              </tr>
                              <tr class="linhas">
                                <td><input type="text" name="descricao[]" required="required"/></td>   
                                <td><a href="#" class="removerCampo" title="Remover linha">Remover resposta</a></td>
                              </tr>
                              <tr><td colspan="4">
                                  <a href="#" class="adicionarCampo" title="Adicionar item">Adicionar resposta</a>
                              </td></tr>
                              <tr>
                                <td align="right" colspan="4"><input type="submit" id="btn-cadastrar" value="Cadastrar" /></td>
                              </tr> 
                            </table>
                          </div>
                        </form>
                        <?php if(isset($resultado_perguntas)): ?>
                          <?php foreach($resultado_perguntas as $questionario):?>
                              <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                  <div class="panel">
                                      <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                      <h4 class="panel-title"><?php echo $questionario['pergunta'] ?></h4>
                                      </a>
                                      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
                                                      <td><?php echo $resposta['resposta'];?></td>
                                                      </tr>
                                                      <?php endforeach;?>
                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>  
                          <?php endforeach;?>
                        <?php endif;?>
                  </div>
                </div>
            </div>
        </div>
   <?php 
   
   include_once '../includes/rodape_pagina.php';
   
   ?>
    <!-- /footer content -->
  </div>
</div>
<?php
include_once '../includes/footer.php';
?>
