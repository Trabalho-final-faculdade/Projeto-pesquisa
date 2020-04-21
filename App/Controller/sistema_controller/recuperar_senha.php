<?php
session_start();
define("sitedir", "http://localhost:8080/nova-senha.php", true);
  require_once('../../../PHPMailer/src/PHPMailer.php');
  require_once('../../../PHPMailer/src/SMTP.php');
  require_once('../../../PHPMailer/src/Exception.php');

  
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['email']) && !empty($_POST['email'])){

  require '../../Model/Conexao.php';
  require '../../Model/UsuarioDao.php';
  require '../../Model/Senha_recuperadaDao.php';
  

  $mail = new PHPMailer(true);

  $ud = new \App\Model\UsuarioDao();
  $sr = new \App\Model\SenhaRecuperadaDao();

  $email = addslashes($_POST['email']);

  $valido = $ud->verificar_email($email);
  $rash = md5(rand());
  if(!empty($valido)){
    if($sr->create($email, $rash) == true){
      try {
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'projeto.pesquisa.tcc.positivo@gmail.com';
          $mail->Password = '@faculdadepositivo123';
          $mail->Port = 587;

          $mail->setFrom('projeto.pesquisa.tcc.positivo@gmail.com');
          $mail->addAddress('dan_casimiro@hotmail.com');

          $mail->isHTML(true);
          $mail->Subject = "Sistema de Pesquisas < Recuperar senha > ";
          $mail->Body = "<h2> Olá, segue o link para recuperar a sua senha</h2>
          <p>Para recuperar sua senha, acesse este link: <a href='".sitedir."?nova-senha.php&rash=$rash'>".sitedir."?nova-senha.php&rash=($rash)</a></p>";
          $mail->AltBody = 'chegou email altbody';

          if($mail->send()) {
              echo 'email enviado com sucesso';
              $_SESSION['recuperar_senha'] = true;
              echo '<script type="text/javascript">window.location = "../../View/sistema/recuperar-senha.php"</script>';
          }else{
              echo 'email nao enviado';
              $_SESSION['recuperar_senha'] = false;
              header("Location: ../../View/sistema/recuperar-senha.php");
          }
      
      }catch (Exception $e){
          echo "erro ao enviar mensagem: {$mail->ErrorInfo}";
          $_SESSION['recuperar_senha'] = false;
          header("Location: ../../View/sistema/recuperar-senha.php");
      }
    }else{

    }
  }else{
    $_SESSION['nao_encontrado'] = true;
    header("Location: ../../View/sistema/recuperar-senha.php");
  }
}
?>