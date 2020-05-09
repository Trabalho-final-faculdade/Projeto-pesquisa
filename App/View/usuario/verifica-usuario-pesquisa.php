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
endforeach;

?>
<form method="post" id="inserir_resposta">
        <div class="modal" tabindex="-1" role="dialog" id="VisualizarPesquisa">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Questões</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="visualizar_pesquisa"></span>
                    </div> 
                </div>
            </div>
        </div>
    </form>
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
                        <input type="hidden" value="<?php echo $_SESSION['id'] ?>" id="usuario_id" />               
                        <div class="form-group row" id="busca">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="email"> <span class="required">Insira aqui o email do entrevistado:</span>
                          </label>
                          <div class="col-md-3 col-sm-3 ">
                            <input type="email" id="email" name="email" required="required" maxlength="50" autocomplete="off" class="form-control ">
                          </div>
                        </div>
                        <div class="ln_solid">
                          <div class="form_group row" id="btnBuscarUsuario">
                            <div class="col-md-6 offset-md-3">
                              <input name="SendPesqUser" type="button" value="Pesquisar" class="btn btn-info btn-xs view_data"><i class="fa fa-pencil"></i>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       <script>
                var index = 1;
                var checkeds = new Array();
                $(document).on('click', '.proxima_pergunta', function(){
                  $("input[name='resposta_selecionada[]']:checked").each(function ()
                    {
                      // valores inteiros usa-se parseInt
                      //checkeds.push(parseInt($(this).val()));
                      // string
                      checkeds.push( $(this).val());
                    });    
                    var pesquisa_id = $("#pesquisa_selecionada").val();
                    var pergunta =  $("#pergunta").val();
                    var resposta_selecionada = $("input[name='resposta_selecionada']:checked").val();
                    var id_usuario = $('#usuario_id').val();
                    var email_usuario = $('#email_usuario').val();
                    if(pesquisa_id != ''){
                        var dados = {
                            pesquisa_id: pesquisa_id,
                            index: index,
                            resposta_selecionada: resposta_selecionada,
                            pergunta: pergunta,
                            id_usuario: id_usuario,
                            email_usuario: email_usuario,
                            array_respostas: checkeds
                        };
                        $.post('../../Controller/pesquisa_controller/buscar-pesquisas-abertas.php', dados, function(retorno){
                            jQuery.noConflict();
                            $('#visualizar_pesquisa').html(retorno);
                            $('#VisualizarPesquisa').modal('show');
                        })
                        index ++;
                    }                     
                });

                $(document).on('click', '.iniciar_pesquisa', function(){
                    var pesquisa_id = $("#select_pesquisa").val();                    
                    if(pesquisa_id != ''){
                        var dados = {
                            pesquisa_id: pesquisa_id[0],
                        };
                        $.post('../../Controller/pesquisa_controller/buscar-pesquisas-abertas.php', dados, function(retorno){
                            jQuery.noConflict();
                            $('#visualizar_pesquisa').html(retorno);
                            $('#VisualizarPesquisa').modal('show');
                        })
                    }                     
                });
                
                $(document).ready(function(){
                  
                    $(document).on('click', '.view_data', function(){
                        var email_usuario = $('#email').val();

                        if(email_usuario != ''){
                          
                            var dados = {
                                email_usuario: email_usuario,
                            };
                            $.post('../../Controller/pesquisa_controller/buscar-pesquisas-abertas.php', dados, function(retorno){
                                jQuery.noConflict();
                                $('#visualizar_pesquisa').html(retorno);
                                $('#VisualizarPesquisa').modal('show');
                            })
                        }
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
