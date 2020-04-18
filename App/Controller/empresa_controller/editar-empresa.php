<?php
session_start();

if(isset($_POST['id']) && !empty($_POST['id']) 
&& isset($_POST['razao_social']) && !empty($_POST['razao_social']) && isset($_POST['cnpj'])
&& !empty($_POST['cnpj']) && isset($_POST['endereco']) && !empty($_POST['endereco'])
&& isset($_POST['complemento']) && !empty($_POST['complemento'])
&& isset($_POST['cidade']) && !empty($_POST['cidade']) && isset($_POST['estado'])
&& !empty($_POST['estado']) && isset($_POST['pais'])
&& !empty($_POST['pais'])  && isset($_POST['cep'])
&& !empty($_POST['cep'])){


  require '../../Model/conexao.php';
  require '../../Model/Empresa.php';
  require '../../Model/EmpresaDao.php';

  $e = new \App\Model\Empresa();
  $ed = new \App\Model\EmpresaDao();

  $e->setRazaoSocial(addslashes($_POST['razao_social']));
  $e->setCnpj(addslashes($_POST['cnpj']));
  $e->setId(addslashes($_POST['id']));
  $e->setEndereco(addslashes($_POST['endereco']));
  $e->setComplemento(addslashes($_POST['complemento']));
  $e->setCidade($_POST['cidade']);
  $e->setEstado(addslashes($_POST['estado']));
  $e->setPais($_POST['pais']);
  $e->setCep($_POST['cep']);

  if($ed->update($e)){
    $_SESSION['cadastro_empresa'] = true;
  }else{
    $_SESSION['cadastro_empresa'] = false;
  }
      
}

header("Location: ../../View/sistema/configuracoes.php");

?>
