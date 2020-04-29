<?php

require_once '../../../vendor/autoload.php';

include_once '../../includes/header.php';
session_start();
if(!isset($_SESSION['id'])):
    header("Location: ../sistema/tela-login.php");
endif;
$count = 1;
$usuario_logado = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
foreach($ud->read($_SESSION['id']) as $usuario):
  $usuario_logado->setNome = $usuario['nome'];
endforeach;

$pd = new \App\Model\PesquisaDao(); 
$p = new \App\Model\Pesquisa();
if(isset($_SESSION['indice'])){
    $i = $_SESSION['indice'];
}else{
    $i = 0;
}

$pergunta = new \App\Model\Pergunta();
$perguntaDao = new \App\Model\PerguntaDao();

$resposta = new \App\Model\Resposta();
$respostaDao = new \App\Model\RespostaDao(); 

$resultados = $pd->buscar_pesquisas_estado("em andamento");
$resultado = $ud->read($_SESSION['id_entrevistado']);

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
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-secondary" type="button">Go!</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                                <form class="form-horizontal form-label-left" action="" method="POST">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 ">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h2>Escolha a pesquisa</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>   
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="x_content">
                                                    <div id="step-1">
                                                        <div class="form-group row">
                                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="cpf"> <span class="required">Nome do entrevistado:</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 ">
                                                                <input type="text" disabled="disabled" id="cpf" value="<?php echo $resultado[0]['nome']?>" name="cpf" required="required" class="form-control" onkeypress="$(this).mask('000.000.000-00');">
                                                            </div>
                                                        </div></br>
                                                        <div class="form-group row">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="busca">Pesquisa: <span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <select name="resultado_pesquisa" id="select" class="form-control" required="required">
                                                                <?php foreach($resultados as $resultado){ ?>
                                                                <option value="<?php echo $resultado['id']?>">
                                                                    <?php echo $resultado['titulo']; ?>
                                                                </option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="ln_solid">
                                                        <div class="form_group" id="btnBuscarUsuario">
                                                            <div class="col-md-6 offset-md-3">
                                                                <input name="SendPesqUser" type="submit" value="Iniciar pesquisa">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                $busca_pesquisa = filter_input(INPUT_POST, 'SendPesqUser', FILTER_SANITIZE_STRING);
                                $select = filter_input(INPUT_POST, 'resultado_pesquisa', FILTER_SANITIZE_STRING);
                                if($busca_pesquisa == true || (isset($_SESSION['indice']) && $_SESSION['indice'] > 0)):
                                    if(isset($_SESSION['pesquisa_id'])):
                                       $select = $_SESSION['pesquisa_id'];
                                    endif;
                                    if(isset($select)):
                                        $todas_perguntas = $perguntaDao->buscar_pergunta_pesquisa($select);
                                    endif;
                                    ?>
                                    <form action="../../Controller/pesquisa_controller/formulario.php" method="POST">
                                        <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                            <div class="panel">
                                                <a class="panel-heading" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                                </a>
                                                <div role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                    <?php if(isset($todas_perguntas[$i]['id'])){?>
                                                        <table class="table table-striped" id="datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo utf8_encode($todas_perguntas[$i]['pergunta']) ?> </th>
                                                                    <input type="hidden" name="indice" value="<?php echo $i ?>">
                                                                    <input type="hidden" name="pesquisa" value="<?php echo $todas_perguntas[$i]['pesquisa_id'] ?>">
                                                                    <input type="hidden" name="pergunta" value="<?php echo $todas_perguntas[$i]['id'] ?>">
                                                                    <input type="hidden" name="operador" value="<?php echo $_SESSION['id'] ?>">
                                                                    <input type="hidden" name="entrevistado" value="<?php echo $_SESSION['id_entrevistado'] ?>">
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>                                      
                                                                    <?php
                                                                    foreach($respostaDao->read($todas_perguntas[$i]['id']) as $r): ?>
                                                                        <?php if($todas_perguntas[$i]['tipo'] == 'dicotonica' || $todas_perguntas[$i]['tipo'] == 'resposta_unica'){ ?>
                                                                            <td><input type='radio' value="<?php echo $r['id'] ?>" name="resposta[]" ><?php echo utf8_encode($r['resposta']) ?></td>
                                                                        <?php  }else{ ?>
                                                                            <td><input type='checkbox' value="<?php echo $r['id'] ?>" name="resposta[]" ><?php echo utf8_encode($r['resposta']) ?></td>
                                                                        <?php  }
                                                                    endforeach;?>
                                                                    </br>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="ln_solid">
                                                            <div class="form_group" id="btnEnviarFormulario">
                                                                <div class="col-md-6 offset-md-3">
                                                                    <input name="SendForm" type="submit" value="Enviar formulário">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }else{
                                                        $_SESSION['indice'] = 0;
                                                        unset($_SESSION['pesquisa_id']);?>
                                                        <div class="alert alert-success" role="alert">
                                                            Pesquisa realizada com sucesso!!!
                                                        </div>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once '../../includes/footer.php';
?>
