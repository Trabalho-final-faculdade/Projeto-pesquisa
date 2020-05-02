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
$nad = new \App\Model\NivelDeAcessoDao();

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
                <h3>Buscar</h3>
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
                    <h2>Buscar usuarios.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                      <form class="form-horizontal form-label-left" action="../pesquisa/pesquisa.php" method="POST">                 
                        <div class="form-group row" id="busca">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="email"> <span class="required">Insira aqui o email do entrevistado:</span>
                          </label>
                          <div class="col-md-3 col-sm-3 ">
                            <input type="email" id="email" name="email" required="required" maxlength="50" autocomplete="off" class="form-control ">
                          </div>
                        </div>
                        <div class="ln_solid">
                          <div class="form_group row" id="btnBuscarUsuario">
                            <div class="col-md-6 offset-md-3">
                              <input name="SendPesqUser" type="submit" value="Pesquisar" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script>
          $(document).ready(function(){
	
          var busca = document.getElementById('busca');
              input_busca = document.getElementById('input_busca');
              select = document.getElementById('select_busca');
              
              function show(){
                if(select.value == ''){
                  busca.style.display = 'none';
                }else{
                  busca.style.display = 'block';
                    
                  input_busca.placeholder = "Insira a informação aqui";
                }
              }
              select.addEventListener('change', function(){
                show();
                
              });
              show();
            });
        </script>
      <?php  
        include_once '../../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
