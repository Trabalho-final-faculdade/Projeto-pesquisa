<?php session_start();

require_once '../../Model/Conexao.php';


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IDEIAA</title>

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
            <form action="../../Controller/pesquisa_controller/buscar-pesquisas.php" method="POST">
              <h1>Verifique as pesquisas disponíveis para você</h1>
              <div>
                <input type="text" name="email" class="form-control" placeholder="Insira seu email aqui" required="" />
              </div>

              <?php
                if(isset($_SESSION['nao_encontrado'])):
              ?>
              <div class="">
                <p>ERRO: Email não cadastrado</p>
              </div>
              <?php
                unset($_SESSION['nao_encontrado']);
              endif;
              ?>
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
                  <h1> IDEIAA</h1>
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
