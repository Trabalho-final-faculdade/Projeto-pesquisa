<?php
session_start();

if(isset($_POST['nome']) && !empty($_POST['nome']) 
&& isset($_POST['aniversario']) && !empty($_POST['aniversario']) && isset($_POST['cpf']) && !empty($_POST['cpf'])
&& isset($_POST['genero']) && !empty($_POST['genero']) && isset($_POST['email']) && !empty($_POST['email'])
&& isset($_POST['senha']) && !empty($_POST['senha']) && isset($_POST['nivel_acesso_id'])
&& !empty($_POST['nivel_acesso_id'])){


require '../../Model/Conexao.php';
require '../../Model/Usuario.php';
require '../../Model/UsuarioDao.php';
require '../../Model/Telefone.php';
require '../../Model/TelefoneDao.php';

$u = new \App\Model\Usuario();
$ud = new \App\Model\UsuarioDao();
$t = new \App\Model\Telefone();
$td = new \App\Model\TelefoneDao();

$t->setTelefone(addslashes($_POST['telefone']));
$t->setCelular(addslashes($_POST['celular']));

$u->setId(addslashes($_POST['id']));
$u->setNome(addslashes($_POST['nome']));
$u->setNascimento(addslashes($_POST['aniversario']));
$u->setCpf(addslashes($_POST['cpf']));
$u->setGenero(addslashes($_POST['genero']));
$u->setEmail(addslashes($_POST['email']));
$u->setSenha(addslashes($_POST['senha']));
$u->setTelefoneId(addslashes($_POST['telefone_id']));
$u->setEnderecoId(1);
$u->setNivelAcessoId(addslashes($_POST['nivel_acesso_id']));
$u->setEmpresaId($_POST['empresa_id']);

if($td->update($t, $u));
  if($ud->update($u)){
    $_SESSION['editar'] = true;
  }else{
    $_SESSION['editar'] = false;
  }
    
}
header("Location: ../../View/usuario/editar-dados.php?id=".$_POST['id']);

?>
