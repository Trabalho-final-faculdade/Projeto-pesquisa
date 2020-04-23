<?php

require_once '../../../vendor/autoload.php';

include_once '../../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$usuario_buscado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$usuario_buscado = $ud->read($_GET['id']);

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
                    <h2>Editando o endereço.</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                    <form class="form-horizontal form-label-left" action="../../Controller/usuario_controller/editar_endereco.php?id=<?php echo $usuario_buscado[0]['id']?>" method="POST" onsubmit="return validaForm(this);">
                    <input type="hidden" name="id" value="<?php echo $usuario_buscado[0]['id'];?>">
                    <input type="hidden" name="endereco_id" value="<?php echo $usuario_buscado[0]['endereco_id'];?>">
                    <?php
                          if(isset($_SESSION['edicao_endereco'])):
                          
                        ?>
                          <div class="alert alert-success" role="alert">
                            Edicao realizado com sucesso!!!
                          </div>
                        <?php 
                            unset($_SESSION['edicao_endereco']);
                          endif;
                        ?>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cep">CEP <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cep" name="cep" required="required" class="form-control" value="<?php echo $usuario_buscado[0]['cep']; ?>" onkeypress="$(this).mask('00000-000');">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="rua">Rua <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="rua" name="rua" minlength="5" value="<?php echo $usuario_buscado[0]['rua'];?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="numero">Número <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="numero" name="numero" required="required" autocomplete="off" maxlength="11" value="<?php echo $usuario_buscado[0]['numero'];?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="complemento">Complemento <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="complemento" name="complemento" required="required" value="<?php echo $usuario_buscado[0]['complemento'];?>" maxlength="50" autocomplete="off" class="form-control ">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="bairro">Bairro <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="bairro" name="bairro" required="required" value="<?php echo $usuario_buscado[0]['bairro'];?>" maxlength="50" autocomplete="off" class="form-control ">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cidade">Cidade <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cidade" name="cidade" minlength="6" required="required" maxlength="50" class="form-control" value="<?php echo $usuario_buscado[0]['cidade']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="estado">Estado <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="estado" name="estado" required="required" class="form-control" value="<?php echo $usuario_buscado[0]['estado']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pais">País <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="pais" name="pais" required="required" class="form-control" value="<?php echo $usuario_buscado[0]['pais']; ?>">
                        </div>
                      </div>
                      <div class="actionBar">
                        <div class="loader">
                          <button type="submit" name="btnCadastrar" class="buttonNext btn btn-success">Editar</button>
                        </div>
                      </div>
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
        include_once '../../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
