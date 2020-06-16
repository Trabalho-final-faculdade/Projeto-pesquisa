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
  $usuario_logado->setNivelAcessoId = $usuario['nivel_acesso_id'];
endforeach;
$pd = new \App\Model\PesquisaDao(); 
$p = new \App\Model\Pesquisa();

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
                <h3>Pesquisas</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
                  <div class="input-group">
                    <span class="input-group-btn">
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
                    <h2>Buscar pesquisa</h2>
                    <ul class="nav navbar-right panel_toolbox">
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                      <form class="form-horizontal form-label-left" action="" method="POST">
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Busca por: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select name="select_busca" id="select_busca" class="form-control" required="required">
                                <option value="">Selecione</option>
                                <option value="id" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "id")) echo "selected"; ?>>ID</option>
                                <option value="titulo" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "titulo")) echo "selected"; ?>>Titulo</option>
                                <option value="estado" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "estado")) echo "selected"; ?>>Estado</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row" id="estado">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Status: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select name="select_estado" id="select_estado" class="form-control">
                                <option value="">Selecione</option>
                                <option value="em andamento" <?php if(isset($_POST['select_estado']) && ($_POST['select_estado'] == "em andamento")) echo "selected"; ?>>Em andamento</option>
                                <option value="concluido" <?php if(isset($_POST['select_estado']) && ($_POST['select_estado'] == "concluido")) echo "selected"; ?>>Concluído</option>
                                <option value="cancelado" <?php if(isset($_POST['select_estado']) && ($_POST['select_estado'] == "cancelado")) echo "selected"; ?>>Cancelado</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row" id="busca">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="input_busca"> <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="input_busca" value="<?php if(isset($_POST['input_busca'])){ echo $_POST['input_busca'];} ?>" name="input_busca" autocomplete="off" class="form-control">
                            </div>
                          </div></br></br>
                          <div class="ln_solid">
                            <div class="form_group" id="btnBuscarUsuario">
                              <div class="col-md-6 offset-md-3">
                                <input name="SendPesqUser" type="submit" value="Pesquisar" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>>                      
                              </div>
                            </div>
                          </div>
                      </form>
                      <?php 
                      $busca_pesquisa = filter_input(INPUT_POST, 'SendPesqUser', FILTER_SANITIZE_STRING);
                      $select = filter_input(INPUT_POST, 'select_estado', FILTER_SANITIZE_STRING);
                      $select_busca = filter_input(INPUT_POST, 'select_busca', FILTER_SANITIZE_STRING);
                      if($busca_pesquisa == true){
                        if(isset($_POST['input_busca']) && $_POST['input_busca'] != "" && $select_busca != 'estado'){
                          $resultados = $pd->buscar_pesquisas($_POST['input_busca'], $select_busca);
                        }else{
                          $resultados = $pd->buscar_pesquisas_estado($select);
                        }
                        if(isset($resultados[0]['id']) && $resultados[0]['id'] > 0){
                        ?>
                        <form>
                        <div class="alert alert-success" role="alert">
                          Pesquisa realizada com sucesso!!!
                        </div>
                        <?php 
                      
                        
                        ?>
                          <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <div class="panel">
                              <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Busca por: <?php echo $_POST['select_busca'] ?></h4>
                              </a>
                              <div role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                  <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Data de início</th>
                                        <th>Data de término</th>
                                        <th>Observação</th>
                                        <th>status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($resultados as $resultado){?>
                                      <tr>
                                      <td><?php echo $resultado['id'] ?> </td> 
                                        <td><?php echo $resultado['titulo'] ?> </td>
                                        <td><?php echo $resultado['observacao'] ?> </td>
                                        <td><?php echo $resultado['status'] ?> </td>
                                        <td> <a href="../../View/pesquisa/estatistica-pesquisa.php?id=<?php echo $resultado['id']?>" class="btn btn-success btn-xs"><i class="fa fa-folder"></i> Estatísticas </a></td>     
                                        <td><a href="../../View/pesquisa/graficos.php?id=<?php echo $resultado['id']?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Gráficos </a></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php 
                        }else{
                         
                        ?>
                        <div class="alert alert-error" role="alert">
                          Nada encontrado na pesquisa!!!
                        </div>
                     
                      <?php }
                    } ?>
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
              estado = document.getElementById('estado');
              
              function show(){
                if(select.value == ''){
                  busca.style.display = 'none';
                  estado.style.display = 'none';
                }else if(select.value == 'estado'){
                  busca.style.display = 'none';
                  estado.style.display = 'block';
                }else{
                  busca.style.display = 'block';
                  estado.style.display = 'none';
                    
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
