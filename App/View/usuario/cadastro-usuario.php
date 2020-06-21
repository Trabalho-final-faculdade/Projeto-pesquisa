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
$nd = new \App\Model\NivelDeAcessoDao();

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
                <h3>Cadastro</h3>
              </div>

              
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cadastro de um novo usuario.</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                       <div id="step-1">
                        <form class="form-horizontal form-label-left" action="../../Controller/usuario_controller/cadastrar.php" method="POST" enctype="multipart/form-data" onsubmit="return validaForm(this);">
                        <?php if(isset($_SESSION['cadastro']) && $_SESSION['cadastro'] == true){ ?>
                          <div class="alert alert-success" role="alert">
                            Cadastro realizado com sucesso!!!
                          </div>
                        <?php unset($_SESSION['cadastro']); } ?>
                        
                        <?php if(isset($_SESSION['email_cadastrado']) && $_SESSION['email_cadastrado'] == true){ ?>
                          <div class="alert alert-danger" role="alert">
                            Email já cadastrado!!!
                          </div>
                        <?php unset($_SESSION['email_cadastrado']); } ?>

                        <?php if(isset($_SESSION['cpf_cadastrado']) && $_SESSION['cpf_cadastrado'] == true){ ?>
                          <div class="alert alert-danger" role="alert">
                            CPF já cadastrado!!!
                          </div>
                        <?php unset($_SESSION['cpf_cadastrado']); } ?>

                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nome">Nome completo <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" id="nome" name="nome" minlength="5" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpf">Cpf <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" id="cpf" name="cpf" minlength="14" required="required" autocomplete="off" maxlength="11" class="form-control" onkeypress="$(this).mask('000.000.000-00');">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="email" id="email" name="email" required="required" maxlength="50" autocomplete="off" class="form-control ">
                            </div>
                          </div>
                         <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="senha">Senha <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="password" id="senha" name="senha" minlength="6" required="required" maxlength="50" class="form-control ">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="senha">Confirmar senha <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="password" id="confirmar_senha" name="confirmar_senha" minlength="6" required="required" maxlength="50" class="form-control ">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nivel_acesso_id">Gênero <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select name="genero" id="genero" class="form-control" required="required">
                                <option value="">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Data de nascimento <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="date" id="aniversario" name="aniversario" class="date-picker form-control" required="required">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="telefone">Telefone fixo <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" id="phone_with_ddd" name="telefone" minlength="13" required="required" autocomplete="off" class="form-control" onkeypress="$(this).mask('(00)0000-0000');">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="celular">Celular <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="tel" id="celular" name="celular" required="required" minlength="14" autocomplete="off" class="form-control" onkeypress="$(this).mask('(00)00000-0000');">
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="arquivos">Foto: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="file" name="arquivos" id="arquivos" required><br>
                            </div>
                          </div>
                           
                          <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="nivel_acesso_id">Nivel de acesso <span class="required">*</span>
                          </label>

                          <?php $query = $nd->read() ?>
                          <div class="col-md-6 col-sm-6 ">
                            <select name="nivel_acesso_id" id="select" class="form-control" required="required">
                              <?php foreach($query as $nivel) { ?>
                                  <option value="<?php echo $nivel['id']?>">
                                      <?php echo $nivel['nivel']; ?>
                                  </option>
                              <?php } ?>
                            </select>
                          </div>
                          
                          <div class="actionBar">
                            <div class="loader">
                            <button type="submit" name="btnCadastrar" class="buttonNext btn btn-success">Cadastrar</button>
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
    <!-- /footer content -->
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
