<?php

require_once '../Model/Usuario.php';
require_once '../Model/Conexao.php';

if(isset($_SESSION['id'])) {
    header("Location: pagina-inicial.php");
}

$objFunc = new \App\Model\Usuario();

if(isset($_POST['btnLogar'])):
  $erros = array();
  $usuario = mysqli_espape_string($instance, $_POST['usuario']);
  $senha = mysqli_espape_string($instance, $_POST['senha']);
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

    <link href="../stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../stylesheets/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../stylesheets/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../stylesheets/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../stylesheets/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="../Controller/logar.php" method="POST">
              <h1>Frase ou banner a escolher</h1>

              <div>
                <input type="text" name="email" class="form-control" placeholder="Insira seu email aqui" required="" />
              </div>
              <div>
                <input type="password" name="senha" class="form-control" placeholder="Insira sua senha aqui" required="" />
              </div>
              <?php
                if(isset($_SESSION['nao_autenticado'])):
              ?>
              <div class="">
                <p>ERRO: Usuário ou senha INVALIDOS</p>
              </div>
              <?php
                unset($_SESSION['nao_autenticado']);
              endif;
              ?>
              <div>
                <button type="submit" name="btnLogar" class="btn btn-default submit">Logar</button>
                <a class="reset_pass" href="#">Esqueci minha senha?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Novo no site?
                  <a href="#signup" class="to_register"> Clique aqui e conheça mais sobre nós </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Nome da empresa!</h1>
                  <p> Breve texto sobre direitos reservados, desde quando a empresa se encontra aberta e termos de privacidade.</p>
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

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>