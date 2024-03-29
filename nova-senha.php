<?php session_start();

require_once 'App/Model/Conexao.php';
require 'App/Model/Senha_recuperadaDao.php';
if(!isset($_GET['rash'])) {
    header("Location: ../sistema/tela-login.php");
}

$sr = new \App\Model\SenhaRecuperadaDao();

$resultado = $sr->read($_GET['rash']);

if(!isset($resultado) || empty($resultado)) {
  header("Location: App/View/sistema/tela-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IDEIAA </title>

    <link href="App/Public/stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="App/Public/stylesheets/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="App/Public/stylesheets/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="App/Public/stylesheets/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="App/Public/stylesheets/custom.min.css" rel="stylesheet">

	<style>
  .TelaFundoLogin{
  	  background: url('https://i.imgur.com/F3oAZAY.png') no-repeat;
	background-size: cover;
	color:Black;
  }
  </style>

  </head>

  <body class="TelaFundoLogin">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="App/Controller/usuario_controller/editar_senha.php" method="POST">
              <h1>Redefinir senha</h1>
              <div>
                <input type="hidden" name="email" class="form-control" value="<?php echo $resultado[0]['email'] ?>" />
                <input type="password" name="senha" class="form-control" placeholder="Insira sua nova senha aqui" required="" />
              </div>    
              <div>
                <button type="submit" name="btnEnviar" class="btn btn-default submit">Enviar dados</button>
                <input type="hidden" name="env" value="form">
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <span style="color:black;">
                <p class="change_link">Novo no site? Conheça mais sobre nós clicando
                  <a href="../../../index.php" class="to_register"> aqui </a>
                </p></span>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>IDEIAA</h1>
                  <p> Todas as pesquisas possuem direitos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
