<?php

require_once '../../../vendor/autoload.php';
require_once '../../Model/Nivel_de_acessoDao.php';


include_once '../../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$usuario_buscado = new \App\Model\Usuario();
$e = new \App\Model\Empresa();
$ed = new \App\Model\EmpresaDao();
$ud = new \App\Model\UsuarioDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$resultados = $ed->read($_GET['id']);
$e->setId($resultados[0]['id']);
$e->setRazaoSocial($resultados[0]['razao_social']);
$e->setCnpj($resultados[0]['cnpj']);
$e->setProprietarioId($resultados[0]['proprietario_id']);
$e->setEndereco($resultados[0]['endereco']);
$e->setComplemento($resultados[0]['complemento']);                      
$e->setCidade($resultados[0]['cidade']);
$e->setEstado($resultados[0]['estado']);
$e->setPais($resultados[0]['pais']);
$e->setCep($resultados[0]['cep']);

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
             
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editando os dados.</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="step-1">
                  <form class="form-horizontal form-label-left" action="../../Controller/empresa_controller/editar-empresa.php?id=<?php echo $e->getId();?>" method="POST" onsubmit="return validaForm(this);"> 
                     <input type='hidden' name="id" id="id" value="<?php echo $e->getId();?>">
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="razao_social">Razao social <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="razao_social" name="razao_social" minlength="5" value="<?php echo $e->getRazaoSocial(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                  
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cnpj">Cnpj <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cnpj" name="cnpj" minlength="5" value="<?php echo $e->getCnpj(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40" onkeypress="$(this).mask('99.999.999/9999-99')">
                        </div>
                      </div>
                  
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="endereco">Endereço: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="endereco" name="endereco" minlength="5" value="<?php echo $e->getEndereco(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                    
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="complemento">Complemento: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="complemento" name="complemento" minlength="5" value="<?php echo $e->getComplemento(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
              
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cidade">Cidade: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cidade" name="cidade" minlength="5" value="<?php echo $e->getCidade(); ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                   
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="estado">Estado: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="estado" name="estado" minlength="5" value="<?php echo $e->getEstado(); ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="pais">País: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="pais" name="pais" minlength="5" value="<?php echo $e->getPais(); ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cep">Cep: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cep" name="cep" minlength="5" value="<?php echo $e->getCep(); ?>" required="required" autocomplete="off" class="form-control" maxlength="40" onkeypress="$(this).mask('99999-999')">
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
