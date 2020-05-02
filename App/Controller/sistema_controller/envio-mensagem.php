<?php
session_start();
  require_once '../../../PHPMailer/src/PHPMailer.php';
  require_once '../../../PHPMailer/src/SMTP.php';
  require_once '../../../PHPMailer/src/Exception.php';
  
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['message']) && !empty($_POST['message'])
&& isset($_POST['name']) && !empty($_POST['name'])){

  require '../../Model/Conexao.php';

  $mail = new PHPMailer(true);
  $message = $_POST['message'];
  $nome = $_POST['name'];
  $email = $_POST['email'];
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
          $mail->Subject = "Sistema de Pesquisas < Fale conosco > ";
          $mail->Body = "<h2> Mensagem enviada do site.</h2>
          <p>Nome: $nome</p>
          <p>email de contato: $email</p>
          <p>$message</p>";
          $mail->AltBody = 'chegou email altbody';

          if($mail->send()) {
              echo 'email enviado com sucesso';
              $_SESSION['envio_mensagem'] = true;
              echo '<script type="text/javascript">window.location = "../../../index.php"</script>';
          }else{
              echo 'email nao enviado';
              $_SESSION['envio_mensagem'] = false;
              header("Location: ../../../index.php");
          }
      
      }catch (Exception $e){
          echo "erro ao enviar mensagem: {$mail->ErrorInfo}";
          $_SESSION['envio_mensagem'] = false;
          header("Location: ../../../index.php");
      }
}
?>