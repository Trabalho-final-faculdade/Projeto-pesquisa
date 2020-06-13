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
$peguntaDao = new \App\Model\PerguntaDao();
$escalas = new \App\Model\EscalaPerguntaDao();

foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$todas_respostas = new \App\Model\RespostaDao();

$todas_perguntas = $peguntaDao->buscar_pergunta_pesquisa($_GET['id']);
?>
<link href="../../Public/stylesheets/morris.css" rel="stylesheet">
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
                <h3>Dados estatísticos</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Gráficos estatísticos da pesquisa</h2>
                    <form class="form-horizontal form-label-left" action="" method="POST">
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Perguntas: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <select name="select_busca" id="select_busca" class="form-control">
                            <option value="">Selecione</option>
                            <?php foreach($todas_perguntas as $pergunta): ?>
                            <option value="<?php echo $pergunta['id'] ?>"><?php echo $pergunta['pergunta'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <input name="SendPesqUser" class="buttonNext btn btn-success" type="submit" value="Pesquisar">  
                      </div> 
                    </form>
                    <?php $busca_usuario = filter_input(INPUT_POST, 'SendPesqUser', FILTER_SANITIZE_STRING); 
                    if($busca_usuario == true){ ?>
                    
                    <?php $select = filter_input(INPUT_POST, 'select_busca', FILTER_SANITIZE_STRING); 
                    $pergunta_selecionada = $peguntaDao->buscar_pergunta($select);
                    if($pergunta_selecionada[0]['tipo'] != 'matriz'){ ?>
                      <div id='graficosLinha' style='width: 900px; height: 500px'></div>
                    <?php }else { ?>
                      <div id='graficosLinhaMatriz' style='width: 900px; height: 500px'></div>
                   <?php }
                    } ?>
                  <div>
                </dv>
                <?php $todas_escalas = $escalas->read(581); ?>
              </div>
            </div>
          </div>
        </div>
      <?php  
        include_once '../../includes/rodape_pagina.php';   
      ?>
  </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript"> 
     select = document.getElementById('select_busca');
  
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['pergunta', 'respostas'],
        <?php foreach($todas_respostas->read($select) as $respostas): ?>
          <?php $votos_por_resposta = $todas_respostas->resultado_por_resposta($respostas['id']);?>
          <?php if((int)$votos_por_resposta[0]['quantidade'] > 0){
            $quantidade = (int)$votos_por_resposta[0]['quantidade'];
          }else{
            $quantidade = 0;
          }?>
          ['<?php echo $respostas['resposta'] ?>', <?php echo $quantidade ?>],
        <?php endforeach;?>
      ]);

      var options = {
        title: '<?php echo $pergunta_selecionada[0]['pergunta'] ?>',
        is3D: true,
      };
      
      var chart = new google.visualization.PieChart(document.getElementById('graficosLinha'));
      
      chart.draw(data, options);
    }
    </script>

<script type="text/javascript"> 
      select = document.getElementById('select_busca');
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {

        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          <?php $todas_escalas = $escalas->read($select); ?>
          ['Month', '<?php echo $todas_escalas[0]['escala_descricao'] ?>', '<?php echo $todas_escalas[1]['escala_descricao'] ?>', '<?php echo $todas_escalas[2]['escala_descricao'] ?>', '<?php echo $todas_escalas[3]['escala_descricao'] ?>'],
         
          <?php foreach($todas_respostas->read($select) as $respostas): ?>
            <?php $votos_por_resposta = $escalas->resultado_por_resposta($pergunta_selecionada[0]['id'], $respostas['id']); ?>

          ['<?php echo $respostas['resposta']?>', <?php echo (int)$votos_por_resposta[0]['quantidade'] ?>, <?php echo (int)$votos_por_resposta[1]['quantidade']?>, <?php echo (int)$votos_por_resposta[2]['quantidade'] ?>, <?php echo (int)$votos_por_resposta[3]['quantidade']?>],
          <?php endforeach; ?>
        ]);

        var options = {
          title : '<?php echo $pergunta_selecionada[0]['pergunta'] ?>',
          vAxis: {title: 'Cups'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}        
        };

        var chart = new google.visualization.ComboChart(document.getElementById('graficosLinhaMatriz'));
        chart.draw(data, options);
      }
    </script>
<?php
include_once '../../includes/footer.php';
?>













