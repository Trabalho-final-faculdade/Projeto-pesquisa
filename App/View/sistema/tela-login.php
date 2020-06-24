<?php
session_start();

require_once '../../Model/Conexao.php';
require_once '../../Model/Usuario.php';

if(isset($_SESSION['id'])) {
    header("Location: ../../View/sistema/pagina-inicial.php");
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

    <title>Pesquisas inteligentes tecnologia | </title>

    <link href="../../Public/stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../Public/stylesheets/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../Public/stylesheets/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../../Public/stylesheets/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../Public/stylesheets/custom.min.css" rel="stylesheet">
  <style>
  .TelaFundoLogin{
  	  background: url('https://i.imgur.com/F3oAZAY.png') no-repeat;
	background-size: cover;
  }
  </style>
  
  </head>

  <body class="TelaFundoLogin">
	

    <div >
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="../../Controller/sistema_controller/logar.php" method="POST">
              <h4><span style="color:black;">Realize o login e consulte as pesquisas em andamento</span></h4>

              <div>
                <input type="text" name="email" class="form-control" placeholder="Insira seu email aqui" required="" />
              </div>
              <div>
                <input type="password" name="senha" class="form-control" placeholder="Insira sua senha aqui" required="" />
              </div>
              <?php
                if(isset($_SESSION['nao_autenticado'])):
              ?>
              <div class="alert alert-danger" role="alert">
                <p>ERRO: Usuário ou senha INVALIDOS</p>
              </div>
              <?php
                unset($_SESSION['nao_autenticado']);
              endif;
              ?>
               <?php
                if(isset($_SESSION['senha_alterada'])):
              ?>
              <div class="alert alert-success" role="alert">
                <p>Senha alterada com sucesso!!!</p>
              </div>
              <?php
                unset($_SESSION['senha_alterada']);
              endif;
              ?>
              <div>
                <button type="submit" name="btnLogar" class="btn btn-default submit">Logar</button>
                <a class="reset_pass" href="../sistema/recuperar-senha.php"> Esqueceu a senha?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator"> <span style="color:black;">
                <p class="change_link">Novo no site? Conheça mais sobre nós clicando
                  <a href="../../../index.php" class="to_register"> aqui </a>
                </p></span>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><span style="color:black;">IDEIAA</span></h1>
				  
                  <p><span style="color:black;"> Todas as pesquisas possuem direitos reservados.</span></p>
                  <!-- <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p> -->
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
