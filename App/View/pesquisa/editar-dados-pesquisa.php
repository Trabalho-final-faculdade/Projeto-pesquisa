<?php

require_once '../../vendor/autoload.php';
require_once '../Model/Nivel_de_acessoDao.php';


include_once '../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$usuario_buscado = new \App\Model\Usuario();
$p = new \App\Model\Pesquisa();
$pd = new \App\Model\PesquisaDao();
$ud = new \App\Model\UsuarioDao();
$perguntaDao = new \App\Model\PerguntaDao();
$respostaDao = new \App\Model\RespostaDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$resultados = $pd->read($_GET['id']);
$p->setId($resultados[0]['id']);
$p->setDataInicial($resultados[0]['data_inicial']);
$p->setDataFinal($resultados[0]['data_final']);
$p->setObservacao($resultados[0]['observacao']);
$p->setTitulo($resultados[0]['titulo']);
$p->setStatus($resultados[0]['status']); 

$todas_perguntas = $perguntaDao->buscar_pergunta_pesquisa($p->getId());

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
                <h3>Editar</h3>
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
                  <div class="x_title">
                    <h2>Editando os dados da pesquisa.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="step-1">
                  <form class="form-horizontal form-label-left" action="../Controller/pesquisa_controller/editar-pesquisa.php" method="POST" onsubmit="return validaForm(this);"> 
                     <input type='hidden' name="id" id="id" value="<?php echo $p->getId();?>">
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="titulo">Título: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="titulo" name="titulo" minlength="5" value="<?php echo $p->getTitulo(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                  
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Data inicial <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="date" id="data_inicial" name="data_inicial" class="date-picker form-control" required="required" value="<?php echo $p->getDataInicial()?>">                            </div>
                      </div>
                  
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Data final <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="date" id="data_final" name="data_final" class="date-picker form-control" required="required" value="<?php echo $p->getDataFinal()?>">                            </div>
                      </div>
                    
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="observacao">Observação: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="observacao" name="observacao" minlength="5" value="<?php echo $p->getObservacao(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="genero">Status <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <select name="status" id="select" class="form-control" required="required">
                            <option value="">Selecione</option>
                            <option value="em andamento" <?php if($p->getStatus() == "em andamento") echo "selected"; ?>>Em andamento</option>
                            <option value="concluido" <?php if($p->getStatus() == "concluido") echo "selected"; ?>>Concluído</option>
                            <option value="cancelado" <?php if($p->getStatus() == "cancelado") echo "selected"; ?>>Cancelado</option>
                          </select>
                        </div>
                      </div>
                      <div class="actionBar">
                        <div class="loader">
                          <button type="submit" name="btnCadastrar" class="buttonNext btn btn-success">Editar</button>
                        </div>
                      </div>
                    </br></br>
                      <h2>Perguntas e respostas.</h2></br></br>
                      <?php foreach($todas_perguntas as $per):?>
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align">Pergunta<span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="text" disabled="true" name="pergunta[<?php echo $per['id']?>]" class="date-picker form-control" required="required" value="<?php echo $per['pergunta']?> ">
                           </div>
                        </div>
                        <?php foreach($respostaDao->read($per['id']) as $resposta):  ?>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="resposta">Resposta: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text"  disabled="true" name="resposta[<?php echo $resposta['id']?>]" minlength="5" value="<?php echo $resposta['resposta'] ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                            </div>
                          </div>
                        <?php endforeach;?>
                        <td><a href="../View/pergunta/editar-dados-pergunta.php?id=<?php echo $per['id']?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a></td>

                      </br>

                      <?php endforeach; ?>
                      
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          function validaForm(frm){

            if(frm.senha.value != frm.confirmar_senha.value ){
              alert("Os campos senha e confirmar senha estão diferentes");
              frm.confirmar_senha.focus();
              return false;
            }
          }
        </script>
      <?php  
        include_once '../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../includes/footer.php';
?>
