<?php 

if(isset($_POST['cadastro']) && !empty($_POST['cadastro']) 
&& isset($_POST['dados_usuario']) && !empty($_POST['dados_usuario']) && isset($_POST['dados_pesquisa'])
&& !empty($_POST['dados_pesquisa']) && isset($_POST['visualizar_pesquisa']) && !empty($_POST['visualizar_pesquisa'])
&& isset($_POST['visualizar_grafico']) && !empty($_POST['visualizar_grafico'])
&& isset($_POST['gerar_relatorio']) && !empty($_POST['gerar_relatorio'])
&& isset($_POST['empresa_id']) && !empty($_POST['empresa_id'])){

    require '../../Model/conexao.php';
    require '../../Model/Configuracao.php';
    require '../../Model/ConfiguracaoDao.php';
  
    $c = new \App\Model\Configuracao();
    $cd = new \App\Model\ConfiguracaoDao();
  
    $c->setEmpresaId(addslashes($_POST['empresa_id']));
    $c->setCadastro(addslashes($_POST['cadastro']));
    $c->setVisualizarDadosUsuario(addslashes($_POST['dados_usuario']));
    $c->setVisualizarDadosPesquisa(addslashes($_POST['dados_pesquisa']));
    $c->setVisualizarResultadoPesquisa(addslashes($_POST['visualizar_pesquisa']));
    $c->setVisualizarGrafico(addslashes($_POST['visualizar_grafico']));
    $c->setGerarRelatorio($_POST['gerar_relatorio']);


    if($cd->read($_POST['empresa_id'])){
        $cd->update($c);
        $_SESSION['cadastro_empresa'] = true;
    }else{
        $cd->create($c);
        $_SESSION['cadastro_empresa'] = false;
    }
   
 }
  
header("Location: ../../View/sistema/configuracoes.php");
  
  ?>

