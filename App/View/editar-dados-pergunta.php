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
$pergunta = new \App\Model\Pergunta();
$perguntaDao = new \App\Model\PerguntaDao();
$respostaDao = new \App\Model\RespostaDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$resultados = $perguntaDao->buscar_pergunta($_GET['id']);
$pergunta->setId($resultados[0]['id']);
$pergunta->setTipoPergunta($resultados[0]['tipo']);
$pergunta->setPergunta($resultados[0]['pergunta']);
$pergunta->setTipoPergunta($resultados[0]['tipo']);

$resultado = $perguntaDao->buscar_pergunta($pergunta->getId());

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
                    <h2>Editando os dados da pergunta.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="step-1">
                  <form class="form-horizontal form-label-left" action="../Controller/pergunta_controller/editar-pergunta.php" method="POST" onsubmit="return validaForm(this);"> 
                     <input type='hidden' name="id" id="id" value="<?php echo $pergunta->getId();?>">
                      <h2>Pergunta e respostas.</h2></br></br>
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align">Pergunta<span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="pergunta" class="date-picker form-control" required="required" value="<?php echo $pergunta->getPergunta() ?> ">
                           </div>
                        </div>
                        <div class="form-group row ">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Tipo da pergunta<span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <select name="tipo_pergunta" id="select" class="form-control" required="required">
                              <option value="">Selecione</option>
                              <option value="dicotonica" <?php if($pergunta->getTipoPergunta() == "dicotonica") echo "selected"; ?>>Dicotônica</option>
                              <option value="matriz" <?php if($pergunta->getTipoPergunta() == "matriz") echo "selected"; ?>>Matriz</option>
                              <option value="multipla_escolha" <?php if($pergunta->getTipoPergunta() == "multipla_escolha") echo "selected"; ?>>Múltiplia escolha</option>
                              <option value="resposta_unica" <?php if($pergunta->getTipoPergunta() == "resposta_unica") echo "selected"; ?>>Resposta única</option>
                            </select>
                          </div>
                        </div>
                        </br>
                        <?php foreach($respostaDao->read($pergunta->getId()) as $resposta): ?>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="resposta">Resposta: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" name="resposta[<?php echo $resposta['id']?>]" minlength="5" value="<?php echo $resposta['resposta'] ?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                            </div>
                          </div>
                        <?php endforeach;?>
                        <div class="actionBar">
                          <div class="loader">
                            <button type="submit" name="btnCadastrar" class="buttonNext btn btn-success">Editar</button>
                          </div>
                        </div>
                      </br>                      
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
