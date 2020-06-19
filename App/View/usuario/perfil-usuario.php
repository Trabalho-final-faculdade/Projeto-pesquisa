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
$usuario_profile = $ud->read($_GET['id']);

if($usuario['nivel_acesso_id'] != '1') {
    header("Location: ../sistema/tela-login.php");
  }
?>
<link href="../../Public/stylesheets/profile.css" rel="stylesheet">
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
                <h3>Perfil</h3>
              </div>

              
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Perfil usuário.</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="step-1">
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-lg-4 pb-5">
                                    <!-- Account Sidebar-->
                                    <div class="author-card pb-3">
                                        <div class="author-card-profile">
                                            <div class="author-card-avatar"><img src="../../Public/imagens/<?php echo  $usuario_profile[0]['foto']?>" alt='Foto de exibição' /><br />>
                                            </div>
                                            <div class="author-card-details">
                                                <h5 class="author-card-name text-lg"><?php echo $usuario_profile[0]['nome'] ?></h5><span class="author-card-position" >Cadastrado em <?php echo date('d/m/Y', strtotime($usuario_profile[0]['criado_em']));?> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard">
                                        <nav class="list-group list-group-flush">
                                           
                                            <a class="list-group-item active" href="#" id="profile_button"  role="button"><i class="fe-icon-user text-muted"></i>Dados do perfil 
                                            
                                            <a class="list-group-item" href="#" id="" role="button"><i class="fe-icon-user text-muted"></i>
                                            </a>
                                        </nav>
                                    </div>
                                </div>
                                
                                <!-- Profile Settings-->
                                <div class="col-lg-8 pb-5" id="profile">
                                    <form class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome">Nome</label>
                                                <input class="form-control" type="text" id="nome" value="<?php echo $usuario_profile[0]['nome']?>" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="genero">Gênero</label>
                                                <input class="form-control" type="text" id="genero" value="<?php echo $usuario_profile[0]['genero'] ?>" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">E-mail </label>
                                                <input class="form-control" type="email" id="email" value="<?php echo $usuario_profile[0]['email'] ?>" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nivel_acesso">Nível de acesso </label>
                                                <input class="form-control" type="text" id="nivel_acesso" value="<?php echo $usuario_profile[0]['nivel'] ?>" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telefone">Telefone</label>
                                                <input type="text" id="telefone1" name="telefone" value="<?php echo $usuario_profile[0]['telefone'] ?>" class="form-control" disabled="true" onkeypress="$(this).mask('(00)0000-0000');">                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="celular">Celular</label>
                                                <input type="text" id="celula1r" name="celular" value="<?php echo $usuario_profile[0]['celular'] ?>" class="form-control" disabled="true" onkeypress="$(this).mask('(00)00000-0000');">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="mt-2 mb-3">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="custom-control custom-checkbox d-block">
                                                    <input class="custom-control-input" type="checkbox" id="subscribe_me" checked="">
                                                </div>
                                                <td> <a href="../usuario/editar-dados.php?id=<?php echo $_GET['id'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Editar perfil </a></td>     
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-8 pb-5" id="endereco">
                                    <form class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome">Rua</label>
                                                <input class="form-control" type="text" id="rua" value="<?php echo $usuario_profile[0]['rua']?>" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="genero">Numero</label>
                                                <input class="form-control" type="text" id="numero" value="<?php echo $usuario_profile[0]['numero'] ?>" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Bairro </label>
                                                <input class="form-control" type="email" id="bairro" value="<?php echo $usuario_profile[0]['bairro'] ?>" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nivel_acesso">Cidade </label>
                                                <input class="form-control" type="text" id="cidade" value="<?php echo $usuario_profile[0]['cidade'] ?>" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="telefone">Estado</label>
                                                <input type="text" id="telefone" name="estado" value="<?php echo $usuario_profile[0]['estado'] ?>" class="form-control" disabled="true" onkeypress="$(this).mask('(00)0000-0000');">                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pais">Pais</label>
                                                <input type="text" id="pais" name="pais" value="<?php echo $usuario_profile[0]['pais'] ?>" class="form-control" disabled="true" onkeypress="$(this).mask('(00)00000-0000');">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cep">CEP</label>
                                                <input type="text" id="cep" name="cep" value="<?php echo $usuario_profile[0]['cep'] ?>" class="form-control" disabled="true" onkeypress="$(this).mask('(00)00000-0000');">
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="custom-control custom-checkbox d-block">
                                                    <input class="custom-control-input" type="checkbox" id="subscribe_me" checked="">
                                                </div>
                                                <td> <a href="../usuario/editar-endereco.php?id=<?php echo $usuario_profile[0]['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Editar endereco </a></td>     
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>                   
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <script>
            $('#profile').show();
            $('#endereco').hide();
            
            $(document).ready(function(){
                $('#profile_button').click(function(){
                    $('#profile').show();
                    $('#endereco').hide();           
                    $("#endereco_button").removeClass("active");
                    $("#profile_button").addClass("active");
                });
                $('#endereco_button').click(function(){
                    $('#profile').hide();
                    $('#endereco').show();
                    $("#profile_button").removeClass("active");
                    $("#endereco_button").addClass("active");
                });
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
