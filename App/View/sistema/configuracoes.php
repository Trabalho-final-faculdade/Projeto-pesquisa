<?php

require_once '../../vendor/autoload.php';

include_once '../includes/header.php';
include_once '../Model/Nivel_de_acessoDao.php';
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: sistema/tela-login.php");
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
endforeach;

$c = new \App\Model\Configuracao();
$cd = new \App\Model\ConfiguracaoDao();

$resultado = $cd->read($_SESSION['empresa_id']);
  $c->setEmpresaId(addslashes($resultado[0]['empresa_id']));
  $c->setCadastro(addslashes($resultado[0]['cadastro']));
  $c->setVisualizarDadosUsuario(addslashes($resultado[0]['visualizar_dados_usuario']));
  $c->setVisualizarDadosPesquisa(addslashes($resultado[0]['visualizar_dados_pesquisa']));
  $c->setVisualizarResultadoPesquisa(addslashes($resultado[0]['visualizar_resultado_pesquisa']));
  $c->setVisualizarGrafico(addslashes($resultado[0]['visualizar_grafico']));
  $c->setGerarRelatorio($resultado[0]['gerar_relatorios']);

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
                <h3>Configuração</h3>
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
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Acessos</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Financeiro</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Demais configurações</a>
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
                          <a href="../View/empresa/editar-dados-empresa.php?id=<?php echo $e->getId()?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
                          </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <form class="form-horizontal form-label-left" action="../Controller/sistema_controller/editar-configuracoes.php" method="POST" >
                         
                        <input type="hidden" name="empresa_id" value="<?php echo $_SESSION['empresa_id']?>">
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="cadastro">Habilitar cadastro:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="cadastro" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getCadastro() == $nivel['id']) echo "selected"?> >
                                        <?php echo $nivel['nivel']; ?>
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="dados_usuario">Habilitar visualização de dados de usuários:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="dados_usuario" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getVisualizarDadosUsuarios() == $nivel['id']) echo "selected"?> >
                                        <?php echo $nivel['nivel']; ?>
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="dados_pesquisa">Habilitar visualização de dados de pesquisas:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="dados_pesquisa" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getVisualizarDadosPesquisa() == $nivel['id']) echo "selected"?>>
                                        <?php echo $nivel['nivel']; ?>
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="visualizar_pesquisa">Habilitar visualização de resultados de pesquisas:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="visualizar_pesquisa" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getVisualizarResultadoPesquisa() == $nivel['id']) echo "selected"?> >
                                        <?php echo $nivel['nivel']; ?>
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="visualizar_grafico">Habilitar visualização de gráficos:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="visualizar_grafico" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getVisualizarGrafico() == $nivel['id']) echo "selected"?> >
                                        <?php echo $nivel['nivel']; ?>
                                    </option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-7 col-sm-6 label-align" for="gerar_relatorio">Habilitar gerar relatórios:
                            </label>
                            <?php $query = $nad->read() ?>
                            <div class="col-md-5 col-sm-14 ">
                              <select name="gerar_relatorio" id="select" class="form-control" required="required">
                                <?php foreach($query as $nivel) { ?>
                                    <option value="<?php echo $nivel['id']?>" <?php if($c->getGerarRelatorio() == $nivel['id']) echo "selected"?>>
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
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">Dados financeiros aqui</div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">Demais dados aqui</div>
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
        include_once '../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<?php
include_once '../includes/footer.php';
?>
