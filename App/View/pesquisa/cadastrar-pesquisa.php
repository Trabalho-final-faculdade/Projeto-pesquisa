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

$ud->read($_SESSION['id']);

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
                <h3>Cadastro pesquisa</h3>
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
                        <form action="../Controller/pesquisa_controller/cadastrar-pesquisa.php" method="POST">
                            <div class="x_title">
                                <h2>Iniciar uma nova pesquisa.</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                    <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="titulo">Titulo da pesquisa: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="titulo" name="titulo" minlength="5" value="" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Data de início <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                <input type="date" id="data_inicial" name="data_inicial" class="date-picker form-control" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Data final <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                <input type="date" id="data_final" name="data_final" class="date-picker form-control" required="required">
                                </div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                    <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="observacao">Observação: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="observacao" name="observacao" minlength="5" value="" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="actionBar">
                                <div class="loader">
                                <button type="submit" name="btnCadastrar" class="buttonNext btn btn-success">Cadastrar pesquisa</button>
                                </div>
                            </div>
                        </form>
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
