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

$e = new \App\Model\Empresa();
$ed = new \App\Model\EmpresaDao();

$resultados = $ed->read($_SESSION['id']);
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
                <h3>Configuração</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Configurações gerais</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-xs-3">
                      <!-- required for floating -->
                      <!-- Nav tabs -->
                      <div class="nav nav-tabs flex-column  bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Dados da empresa</a>
                      </div>
            
                    </div>

                    <div class="col-xs-9">
                      <!-- Tab panes -->
                     
                      <div class="tab-content">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <form class="form-horizontal">  
                        <div class="form-group row">
                          <label for="staticEmail" class="control-label col-sm-5">Razão social: </label>
                          <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getRazaoSocial(); ?>">
                            </div>
                          </div> 
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Cnpj: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=" <?php echo $e->getCnpj(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Endereço: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getEndereco(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Complemento: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getComplemento(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Cidade: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getCidade(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Estado: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getEstado(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">País: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getPais(); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="staticEmail" class="control-label col-sm-5">Cep: </label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $e->getCep(); ?>">
                            </div>
                          </div>
                          <a href="../empresa/editar-dados-empresa.php?id=<?php echo $e->getId()?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
                          </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        
                      </div>
                    </div>

                    <div class="clearfix"></div>

                  </div>
                </div>
              </div>
             
            </div>
          </div>
        </div>
      
      <?php  
        include_once '../../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
