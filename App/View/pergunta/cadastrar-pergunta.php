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
$pergunta = new \App\Model\Pergunta();
$perguntaDao = new \App\Model\PerguntaDao();
$p = new \App\Model\Pesquisa();
$pd = new \App\Model\PesquisaDao();
$respostas = new \App\Model\Resposta();
$respostasDao = new \App\Model\RespostaDao();

$resultado_perguntas = $perguntaDao->buscar_pergunta_pesquisa($_GET['id']);

$resultado = $pd->read($_GET['id']);
$p->setId(addslashes($resultado[0]['id']));
$p->setObservacao(addslashes($resultado[0]['observacao']));
$p->setTitulo(addslashes($resultado[0]['titulo']));
$p->setStatus(addslashes($resultado[0]['status']));
$p->setFechada(addslashes($resultado[0]['fechada']));
$i = 1;
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
                <h3>Cadastro pergunta</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            </style>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript">
          
            </script>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <form method="POST" name="frm_campo_dinamico" action="../../Controller/pergunta_controller/cadastrar-pergunta-resposta.php">
                          <div class="x_title">
                                <?php
                                  if(isset($_SESSION['pesquisa_cadastrada']) && $_SESSION['pesquisa_cadastrada'] == true):
                                ?>
                                <div class="alert alert-success" role="alert">
                                  <p>Pesquisa cadastrada com sucesso!!!</p>
                                </div>
                                <?php
                                  unset($_SESSION['pesquisa_cadastrada']);
                                endif;
                                ?>
                                <h2>Cadastrar pergunta.</h2>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="pesquisa">Pergunta relacionada a pesquisa: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="hidden" id="pesquisa" name="pesquisa" minlength="5" value="<?php echo $p->getId()?>" required="required" autocomplete="off" class="form-control" maxlength="40">  
                                  <input type="text" id="" disabled="true" name="" minlength="5" value="<?php echo $p->getTitulo()?>" required="required" autocomplete="off" class="form-control" maxlength="40">
                                </div>
                            </div>
                            <div class="x_content">
                                <div id="step-1">
                                  <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="pergunta">Pergunta: <span class="required">*</span>
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                  <input type="text" id="pergunta" name="pergunta" minlength="5" value="" required="required" autocomplete="off" class="form-control" maxlength="100">
                                </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="genero">Tipo de pergunta <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                <select name="tipo_pergunta" id="select" class="form-control" required="required">
                                  <option value="">Selecione</option>
                                  <option value="matriz">Matriz</option>
                                  <option value="multipla_escolha">Múltiplia escolha</option>
                                  <option value="resposta_unica">Resposta única</option>
                                </select>
                              </div>
                            </div>
                          </br>
                          <h2>Cadastrar respostas.</h2>
                              
                          <form>
                            <div id="formulario"> 
                                  <button type="button" id="add-campo"> Adicionar pergunta </button>
                            </div>
                          <div id="matriz_ativada">
                            <h2>Cadastrar Escalas.</h2>
                            <div id="formulario_escala">
                                  <button type="button" id="add-escala"> Adicionar escala </button>
                            </div>
                          </div>
                            <input type="submit" id="btn-cadastrar" value="Cadastrar" class="btn btn-danger">  
                            <?php if(isset($resultado_perguntas) && count($resultado_perguntas) >= 3){ ?>
                              <?php if($p->getFechada() == "1"){ ?>
                                <a href="../../Controller/pesquisa_controller/enviar-pesquisa-email.php?id=<?php echo $p->getId()?>" class="btn btn-info btn-xs"> Finalizar pesquisa </a>
                              <?php }else{ 
                                $_SESSION['pesquisa_cadastrada'] = true;?>
                                <a href="../../View/pesquisa/cadastrar-pesquisa.php" class="btn btn-info btn-xs"> Finalizar pesquisa </a>
                              <?php }?>
                            <?php } ?>

                            
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script>
                                var cont = 1;
                                var cont_escala = 1;
                                $('#add-campo').click(function () {
                                    cont++;
                                    $('#formulario').append('<div class="form-group row" id="campo' + cont + '"> <label class="col-md-3 col-sm-3 label-align">Resposta</label><div class="col-md-3 col-sm-3"><input type="text" name="titulo['+cont+']" class="form-control" required="required"><button type="button" id="' + cont + '" class="btn-apagar"> - </button></br></div></div>');
                                });                                                              
                                                            
                                $('form').on('click', '.btn-apagar', function () {
                                    var button_id = $(this).attr("id");
                                    $('#campo' + button_id + '').remove();
                                });

                                $('#add-escala').click(function () {
                                    cont_escala++;
                                    $('#formulario_escala').append('<div class="form-group row" id="campo_escala' + cont_escala + '"> <label class="col-md-3 col-sm-3 label-align">Resposta</label><div class="col-md-3 col-sm-3"><input type="text" required="required" name="escala['+cont_escala+']" class="form-control"><button type="button" id="' + cont_escala + '" class="btn-apagar-escala"> - </button></br></div></div>');
                                });                                                              
                                                            
                                $('form').on('click', '.btn-apagar-escala', function () {
                                    var button_id = $(this).attr("id");
                                    $('#campo_escala' + button_id + '').remove();
                                });
                                
                                
                                $(document).ready(function(){
                                  var matriz = document.getElementById('matriz_ativada');
                                      select = document.getElementById('select');

                                  function show(){
                                    if(select.value == 'matriz'){
                                      matriz.style.display = 'block';
                                    }else{
                                      matriz.style.display = 'none';
                                    }
                                  }
                                  select.addEventListener('change', function(){
                                    show();
                                    
                                  });
                                  show();
                                });
                               
                            </script>
                          </form>
                        <form>
                        <?php if(isset($resultado_perguntas)): ?>
                          <?php foreach($resultado_perguntas as $questionario):
                            $i += 1;?>
                              <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                  <div class="panel">
                                      <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i?>" aria-expanded="true" aria-controls="collapseOneaaa">
                                      <h4 class="panel-title"><?php echo $questionario['pergunta'] ?></h4>
                                      </a>
                                      <div id="collapseOne<?php echo $i?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
                      </form>
                  </div>
                </div>
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
