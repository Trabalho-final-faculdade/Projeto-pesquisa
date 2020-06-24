<?php

require_once '../../../vendor/autoload.php';

include_once '../../includes/header.php';

session_start();
if(!isset($_SESSION['id'])) {
    header("Location: ../sistema/tela-login.php");
}

$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$pesquisas = new \App\Model\PesquisaDao();
$ud->read($_SESSION['id']);
$todos_usuarios = $ud->todos_usuarios();
$count = 0;
foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
  $usuario_logado->setNivelAcessoId = $usuario['nivel'];
  $usuario_logado->setFoto = $usuario['foto'];
endforeach;
$pesquisas_andamento = $pesquisas->buscar_pesquisas_estado('em andamento');
if(isset($pesquisas_andamento) && !empty($pesquisas_andamento)){
  $pesquisas_andamento = count($pesquisas_andamento);
}else{
  $pesquisas_andamento = 0;
}

$pesquisas_realizadas = $pesquisas->retornar_numero_pesquisas_realizadas();

?>
<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <?php 
            include_once '../../includes/imagem_empresa.php';        
       ?>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
       <?php 
            include_once '../../includes/left_menu.php';        
       ?>
    <!-- top navigation -->
       <?php 
            include_once '../../includes/menu_top.php';
       ?>
    <!-- /top navigation -->

    <!-- page content -->
 
    <div class="right_col" role="main">
      <!-- top tiles -->
      <div class="row" style="display: block;" >
      <?php if($usuario['nivel'] == "Administrador"){ ?>
        <div class="tile_count">
          <div class="col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total de usuários</span>
            <div class="count"><?php echo count($todos_usuarios) ?></div>
          </div>
          <div class="col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Pesquisas andamento </span>
            <div class="count"><?php echo $pesquisas_andamento ?> </div>
          </div>
          <div class="col-sm-4  tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Pesquisas respondidas</span>
            <div class="count"><?php echo count($pesquisas_realizadas) ?> </div>
          </div>
        </div> 
      <?php  } ?> 
	  
		
		
		
		


      </div>
	  <div  style="text-align: center;font-size: 40px;color:black;background-size: cover; text-align: center; line-height: 30px; font-size: 120%">
					 <h1><b>I.D.E.I.<span style="color:blue;">A</span>.A <b><h1>
					 
		</div>
		<div class="inner" style="background-size: cover; line-height: 30px; font-size: 120%; text-align: center;">
		
					 <b><span style="color:black; font-size: 20px;text-align: center;">
					 (Investigar, descobrir, Entender, Inovar, Analisar, Agir)
					 </span> <b>
		</div>
    </div>
      <!-- /top tiles -->
  
  </div>
</div>
	
</div>

   
 <?php include_once '../../includes/rodape_pagina.php';
   
   ?>
    <!-- /footer content -->
 
<?php
include_once '../../includes/footer.php';
?>
