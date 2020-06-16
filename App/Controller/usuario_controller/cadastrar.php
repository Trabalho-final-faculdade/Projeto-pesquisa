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

  if($ud->verificar_email($_POST['email'])){
    $_SESSION['email_cadastrado'] = true;
    $_SESSION['cpf_cadastrado'] = false;
    $_SESSION['cadastro'] = false;
    header("Location: ../../View/usuario/cadastro-usuario.php");
    exit;
  }

  if($ud->verificar_cpf($_POST['cpf'])){
    $_SESSION['cpf_cadastrado'] = true;
    $_SESSION['cadastro'] = false;
    $_SESSION['email_cadastrado'] = false;

    header("Location: ../../View/usuario/cadastro-usuario.php");
    exit;
  }

  $t->setTelefone(addslashes($_POST['telefone']));
  $t->setCelular(addslashes($_POST['celular']));
  $td->create($t);

  $u->setNome(addslashes($_POST['nome']));
  $u->setNascimento(addslashes($_POST['aniversario']));
  $u->setCpf(addslashes($_POST['cpf']));
  $u->setGenero(addslashes($_POST['genero']));
  $u->setEmail(addslashes($_POST['email']));
  $u->setSenha(addslashes($_POST['senha']));
  $u->setEnderecoId($_SESSION['empresa_id']);
  foreach($td->salvar_telefone($t) as $telefones):
    $u->setTelefoneId($telefones['id']);
  endforeach;
  $u->setNivelAcessoId(addslashes($_POST['nivel_acesso_id']));
  $u->setEmpresaId($_SESSION['empresa_id']);

  if($ud->create($u) == true){
    $_SESSION['cadastro'] = true;
    header("Location: ../../View/usuario/cadastro-usuario.php");

  }else{
    $_SESSION['cadastro'] = false;
   // header("Location: ../../View/usuario/cadastro-usuario.php");

  }
    
}
//header("Location: ../../View/usuario/cadastro-usuario.php");
?>
