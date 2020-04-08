<?php

require_once '../../vendor/autoload.php';

include_once '../includes/header.php';
include_once '../Model/Nivel_de_acessoDao.php';
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: tela-login.php");
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
          include_once '../includes/imagem_empresa.php';   
          include_once '../includes/left_menu.php';    
          include_once '../includes/menu_top.php';    
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
                      <form class="form-horizontal form-label-left" action="" method="POST">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Busca por: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select name="select_busca" id="select_busca" class="form-control" required="required">
                                <option value="">Selecione</option>
                                <option value="id" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "id")) echo "selected"; ?>>ID</option>
                                <option value="nome" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "nome")) echo "selected"; ?>>Nome</option>
                                <option value="cpf" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "cpf")) echo "selected"; ?>>Cpf</option>
                                <option value="nivel" <?php if(isset($_POST['select_busca']) && ($_POST['select_busca'] == "nivel")) echo "selected"; ?>>Nivel</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row" id="busca">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="input_busca"> <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="input_busca" value="<?php if(isset($_POST['input_busca'])){ echo $_POST['input_busca'];} ?>" name="input_busca" required="required" autocomplete="off" class="form-control">
                            </div>
                          </div>
                          <div class="ln_solid">
                            <div class="form_group" id="btnBuscarUsuario">
                              <div class="col-md-6 offset-md-3">
                              <input name="SendPesqUser" type="submit" value="Pesquisar">                              </div>
                            </div>
                          </div>
                      </form>
                      <?php 
                      $busca_usuario = filter_input(INPUT_POST, 'SendPesqUser', FILTER_SANITIZE_STRING);
                      $select = filter_input(INPUT_POST, 'select_busca', FILTER_SANITIZE_STRING);
                      $valor = filter_input(INPUT_POST, 'input_busca', FILTER_SANITIZE_STRING);
                      if($busca_usuario == true){
                        $resultados = $ud->buscar_usuarios($select, $valor, $_SESSION['empresa_id']);
                      
                        if(isset($resultados[0]['id']) && $resultados[0]['id'] > 0){
                        ?>
                        <form>
                        <div class="alert alert-success" role="alert">
                          Pesquisa realizada com sucesso!!!
                        </div>
                          <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <div class="panel">
                              <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Busca por: <?php echo $select ?></h4>
                              </a>
                              <div role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                  <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>Nível de acesso</th>
                                        <th>Perfil</th>
                                        <th>Dados</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach($resultados as $resultado){
                                        $na = $nad->buscar_nivel($resultado['nivel_acesso_id']) ?>
                                      <tr>
                                        <td><?php echo $resultado['id'] ?> </td> 
                                        <td><?php echo $resultado['nome'] ?> </td>
                                        <td><?php echo $resultado['cpf'] ?> </td>
                                        <td><?php echo $na[0]['nivel'] ?> </td>
                                        <td> <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Visualizar </a></td>     
                                        <td><a href="../View/editar-dados.php?id=<?php echo $resultado['id']?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a></td>
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
        include_once '../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../includes/footer.php';
?>
