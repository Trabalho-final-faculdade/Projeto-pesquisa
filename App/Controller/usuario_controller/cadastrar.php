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
  $foto = $_FILES["arquivos"];
  if (!empty($foto["name"])) {
        
    // Largura máxima em pixels
    $largura = 850;
    // Altura máxima em pixels
    $altura = 880;
    // Tamanho máximo do arquivo em bytes
    $tamanho = 200000;
    $error = array();
    // Verifica se o arquivo é uma imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
        $error[1] = "Isso não é uma imagem.";
        } 
      
    // Pega as dimensões da imagem
    $dimensoes = getimagesize($foto["tmp_name"]);

    // Verifica se a largura da imagem é maior que a largura permitida
    if($dimensoes[0] > $largura) {
        $error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
    }
    // Verifica se a altura da imagem é maior que a altura permitida
    if($dimensoes[1] > $altura) {
        $error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
    }
    
    // Verifica se o tamanho da imagem é maior que o tamanho permitido
    if($foto["size"] > $tamanho) {
            $error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
    }
    // Se não houver nenhum erro
    if (count($error) == 0) {
    
        // Pega extensão da imagem
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
        // Gera um nome único para a imagem
        $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
        // Caminho de onde ficará a imagem
        $caminho_imagem = "../../Public/imagens/" . $nome_imagem;
        // Faz o upload da imagem para seu respectivo caminho
        move_uploaded_file($foto["tmp_name"], $caminho_imagem);
      
    }

    // Se houver mensagens de erro, exibe-as
    if (count($error) != 0) {
        foreach ($error as $erro) {
            echo $erro . "<br />";
        }
    }
}

  $t->setTelefone(addslashes($_POST['telefone']));
  $t->setCelular(addslashes($_POST['celular']));
  $td->create($t);
  $u->setFoto($nome_imagem);
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
    header("Location: ../../View/usuario/cadastro-usuario.php");

  }
    
}
header("Location: ../../View/usuario/cadastro-usuario.php");
?>
