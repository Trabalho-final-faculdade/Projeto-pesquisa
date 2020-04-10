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
$pd = new \App\Model\PesquisaDao(); 
$p = new \App\Model\Pesquisa();
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
                <h3>Pesquisas</h3>
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
                    <h2>Pesquisas concluídas.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                     
                      <?php 
                        $resultados = $pd->buscar_pesquisas("concluido");
                      
                        if(isset($resultados[0]['id']) && $resultados[0]['id'] > 0){
                        ?>
                        <form>
                          <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                            <div class="panel">
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
                                      <?php foreach($resultados as $resultado){ ?>
                                      <tr>
                                        <td><?php echo $resultado['id'] ?> </td> 
                                        <td><?php echo $resultado['titulo'] ?> </td>
                                        <td><?php echo date('d-m-Y', strtotime($resultado['data_inicial'])); ?> </td>
                                        <td><?php echo date('d-m-Y', strtotime($resultado['data_final'])); ?> </td>
                                        <td><?php echo $resultado['observacao'] ?> </td>
                                        <td><?php echo $resultado['status'] ?> </td>
                                        <td> <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Visualizar </a></td>     
                                        <td><a href="../View/editar-dados-pesquisa.php?id=<?php echo $resultado['id']?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a></td>
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
                            <input type="text" value="<?php var_dump($resultados)?>">
                          Nada encontrado na pesquisa!!!
                        </div>
                     
                      <?php }
                     ?>
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
