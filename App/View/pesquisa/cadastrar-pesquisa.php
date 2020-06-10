<?php

require_once '../../../vendor/autoload.php';
require_once '../../Model/Nivel_de_acessoDao.php';


include_once '../../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();

$ud->read($_SESSION['id']);

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
  $usuario_logado->setNivelAcessoId = $usuario['nivel_acesso_id'];
endforeach;

if($usuario['nivel_acesso_id'] != '1') {
  header("Location: ../sistema/tela-login.php");
}
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
                <h3>Cadastro pesquisa</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <form action="../../Controller/pesquisa_controller/cadastrar-pesquisa.php" method="POST" enctype="multipart/form-data">
                            <?php if(isset($_SESSION['pesquisa_cadastrada'])): ?>
                              <div class="alert alert-success" role="alert">Pesquisa cadastrada com sucesso!!!</div>
                            <?php unset($_SESSION['pesquisa_cadastrada']); endif; ?> 

                            <?php if(isset($_SESSION['arquivo_invalido'])): ?>
                              <div class="alert alert-error" role="alert">Por gentileza, adicione um arquivo com extensão csv.</div>
                            <?php unset($_SESSION['arquivo_invalido']); endif; ?>  

                            <?php if(isset($_SESSION['pesquisa_finalizada'])): ?>
                              <div class="alert alert-error" role="alert">Pesquisa finalizada com sucesso.</div>
                            <?php unset($_SESSION['pesquisa_finalizada']); endif; ?>  
                            <div class="x_title">
                                <h2>Iniciar uma nova pesquisa.</h2>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                    <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="titulo">Titulo da pesquisa: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="titulo" name="titulo" minlength="5" value="" required="required" autocomplete="off" class="form-control" maxlength="100">
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
                                    <input type="text" id="observacao" name="observacao" minlength="5" value="" required="required" autocomplete="off" class="form-control" maxlength="100">
                                </div>
                            </div>
                            <div class="form-group row" id="estado">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Pesquisa fechada: <span class="required">*</span>
                            </label>
                              <div class="col-md-6 col-sm-6 ">
                                <select name="select_pesquisa" id="select_pesquisa" class="form-control">
                                  <option value="1">Sim</option>
                                  <option value="0">Não</option>
                                </select>
                              </div>
                            </div>
                            <div class="x_content" id="div_arquivos">
                              <div id="step-1">
                                  <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="arquivos">Emails: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                      <input type="file" name="arquivos" id="arquivos"><br>
                                    </div>
                                  </div>
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
                <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
              <script>
                $(document).ready(function(){
                  var pesquisa_fechada = document.getElementById('select_pesquisa');
                      arquivos = document.getElementById('div_arquivos');

                  function show(){
                    if(pesquisa_fechada.value == '1'){
                      arquivos.style.display = 'block';
                    }else{
                      arquivos.style.display = 'none';
                    }
                  }
                  pesquisa_fechada.addEventListener('change', function(){
                    show();
                    
                  });
                  show();
                });


              </script>
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
