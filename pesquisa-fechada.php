<?php

require_once 'vendor/autoload.php';

session_start();

$ud = new \App\Model\UsuarioDao();
$epd = new \App\Model\EnviarPesquisaDao();
$pesquisaDao = new \App\Model\PesquisaDao(); 

$usuario_email = $ud->verificar_email($_GET['email']);
$pesquisas_encontradas = $epd->buscar_pesquisas_nao_realizadas($usuario_email[0]['email']);
if(isset($pesquisas_encontradas) && !empty($pesquisas_encontradas)):
    foreach($pesquisas_encontradas as $pesquisa):
        $ids_pesquisas[] = $pesquisa['pesquisa_id'];
    endforeach;
endif;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Nome da empresa | </title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="App/Public/stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="App/Public/stylesheets/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="App/Public/stylesheets/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="App/Public/stylesheets/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="App/Public/stylesheets/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
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
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
           <form>
           <?php if(isset($pesquisas_encontradas) && !empty($pesquisas_encontradas)){ ?>
                <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                        <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">Selecione a pesquisa:</h4>
                        </a>
                        <div role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Pesquisa</th>
                                            <th>Selecione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($ids_pesquisas as $id): ?>
                                            <?php foreach($pesquisaDao->read($id) as $p): ?>
                                        <tr>
                                            <input type="hidden" id="id_usuario" value="<?php echo $usuario_email[0]['id'] ?>">
                                            <input type="hidden" id="email_usuario" value="<?php echo $usuario_email[0]['email'] ?>">
                                            <td> <?php echo $p['titulo'] ?></td>
                                            <td><button type="button" class="btn btn-outline-primary view_data" id="<?php echo $p['id'] ?>">Selecionar</button> </td>
                                        </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else{
                echo "nenhuma pesquisa encontrada";
            }?>
            </form>              
          
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <script>
                var index = 1;
                var checkeds = new Array();
                var array_matriz = new Array();
                var array_escala_matriz = new Array();
                
                function adicionaResposta(obj, id_resposta){
                  array_matriz[id_resposta] = obj.value;   
                } 
                //var id_usuario = document.getElementById('id_usuario');
                $(document).ready(function(){
                    $(document).on('click', '.proxima_pergunta', function(){
                        $("input[name='resposta_selecionada[]']:checked").each(function ()
                        {
                        // valores inteiros usa-se parseInt
                        //checkeds.push(parseInt($(this).val()));
                        // string
                            checkeds.push( $(this).val());
                        });    
                        for(var i = 0; i <= array_matriz.length; i++){
                            if(typeof(array_matriz[i]) != 'undefined'){
                                array_escala_matriz.push(array_matriz[i]);
                            }
                        }
                        var pesquisa_id = $(this).attr('id');
                        var pergunta =  $("#pergunta").val();
                        var resposta_selecionada = $("input[name='resposta_selecionada']:checked").val();
                        var id_usuario = $('#id_usuario').val();
                        var email_usuario = $('#email_usuario').val();
                        
                        if(pesquisa_id != ''){
                            var dados = {
                                pesquisa_id: pesquisa_id,
                                index: index,
                                resposta_selecionada: resposta_selecionada,
                                pergunta: pergunta,
                                id_usuario: id_usuario,
                                email_usuario: email_usuario,
                                array_respostas: checkeds,
                                array_escala_matriz: array_escala_matriz,
                            };
                            $.post('App/Controller/pergunta_controller/perguntas_fechadas.php', dados, function(retorno){
                                jQuery.noConflict();
                                $('#visualizar_pesquisa').html(retorno);
                                $('#VisualizarPesquisa').modal('show');
                            })
                            index ++;
                            checkeds = new Array();
                            array_matriz = new Array();
                            array_escala_matriz = new Array();
                        }                     
                    });
                    $(document).on('click', '.view_data', function(){
                        var pesquisa_id = $(this).attr('id');
                        var email_usuario = $('#email_usuario').val();

                        if(pesquisa_id != ''){
                            var dados = {
                                pesquisa_id: pesquisa_id,
                                email_usuario: email_usuario,
                            };
                            $.post('App/Controller/pergunta_controller/perguntas_fechadas.php', dados, function(retorno){
                                jQuery.noConflict();
                                $('#visualizar_pesquisa').html(retorno);
                                $('#VisualizarPesquisa').modal('show');
                            })
                        }
                    });
                });


            </script>
        </div>
      </div>
    </div>
  </body>
</html>