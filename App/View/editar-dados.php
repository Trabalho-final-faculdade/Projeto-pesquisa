<?php

require_once '../../vendor/autoload.php';
require_once '../Model/Nivel_de_acessoDao.php';


include_once '../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$usuario_buscado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$telefone = new \App\Model\Telefone();
$telefoneDao = new \App\Model\TelefoneDao();
$nd = new \App\Model\NivelDeAcessoDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

foreach($ud->read($_GET['id']) as $ub):
    $usuario_buscado->setNome($ub['nome']);
    $usuario_buscado->setId($ub['id']);
    $usuario_buscado->setCpf($ub['cpf']);
    $usuario_buscado->setEmail($ub['email']);
    $usuario_buscado->setGenero($ub['genero']);
    $usuario_buscado->setNascimento($ub['data_nascimento']);
    $usuario_buscado->setNivelAcessoId($ub['nivel_acesso_id']);
endforeach;

$retorno_telefone = $telefoneDao->buscar_telefone($ub['telefone_id']);
$telefone->setTelefone($retorno_telefone[0]['telefone']);
$telefone->setCelular($retorno_telefone[0]['celular']);

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
                    <h2>Editando os dados.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                    <form class="form-horizontal form-label-left" action="../Controller/usuario_controller/editar.php?id=<?php echo $_GET['id']?>" method="POST" onsubmit="return validaForm(this);">
                    <input type="hidden" name="id" value="<?php echo $usuario_buscado->getId();?>">
                    <input type="hidden" name="telefone_id" value="<?php echo $retorno_telefone[0]['id'];?>">
                    <?php
                          if(isset($_SESSION['editar'])):
                          
                        ?>
                          <div class="alert alert-success" role="alert">
                            Edicao realizado com sucesso!!!
                          </div>
                        <?php 
                            unset($_SESSION['editar']);
                          endif;
                        ?>
                    
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nome">Nome completo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="nome" name="nome" minlength="5" value="<?php echo $usuario_buscado->getNome();?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required="required" autocomplete="off" class="form-control" maxlength="40">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpf">Cpf <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="cpf" name="cpf" minlength="14" required="required" autocomplete="off" maxlength="11" value="<?php echo $usuario_buscado->getCpf()?>" class="form-control" onkeypress="$(this).mask('000.000.000-00');">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="email" id="email" name="email" required="required" value="<?php echo $usuario_buscado->getEmail();?>" maxlength="50" autocomplete="off" class="form-control ">
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
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="confirmar_senha">Confirmar senha <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="password" id="confirmar_senha" name="confirmar_senha" required="required" class="form-control ">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="genero">Gênero <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <select name="genero" id="select" class="form-control" required="required">
                            <option value="">Selecione</option>
                            <option value="Masculino" <?php if($usuario_buscado->getGenero() == "Masculino") echo "selected"; ?>>Masculino</option>
                            <option value="Feminino" <?php if($usuario_buscado->getGenero() == "Feminino") echo "selected"; ?>>Feminino</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Data de nascimento <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="date" id="aniversario" name="aniversario" class="date-picker form-control" required="required" value="<?php echo $usuario_buscado->getNascimento()?>">                            </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="telefone">Telefone fixo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="telefone" name="telefone" value="<?php echo $telefone->getTelefone()?>" required="required" class="form-control" onkeypress="$(this).mask('(00)0000-0000');">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="celular">Celular <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" id="celular" name="celular" value="<?php echo $telefone->getCelular()?>" required="required" class="form-control" onkeypress="$(this).mask('(00)00000-0000');">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nivel_acesso_id">Nivel de acesso <span class="required">*</span>
                        </label>
                        <?php $query = $nd->read() ?>
                        <div class="col-md-6 col-sm-6 ">
                          <select name="nivel_acesso_id" id="select" class="form-control" required="required">
                            <?php foreach($query as $nivel) { ?>
                                <option value="<?php echo $nivel['id']?>" <?php if($nivel['id'] == $usuario_buscado->getNivelAcessoId()) echo "selected"; ?>>
                                    <?php echo $nivel['nivel']; ?>
                                </option>
                            <?php } ?>
                          </select>
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
        include_once '../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../includes/footer.php';
?>
