<?php
session_start();

define("sitedir", "http://localhost:8080/pesquisa-fechada.php", true);
  require_once('../../../PHPMailer/src/PHPMailer.php');
  require_once('../../../PHPMailer/src/SMTP.php');
  require_once('../../../PHPMailer/src/Exception.php');
  
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\PHPMailer;


if(isset($_GET['id']) && !empty($_GET['id'])){
    
  require '../../Model/Conexao.php';
  require_once('../../Model/EnviarPesquisaDao.php');

  

  $mail = new PHPMailer(true);

  $ep = new \App\Model\EnviarPesquisaDao();

  $emails = $ep->read($_GET['id']);

  foreach($emails as $email):
    $send_email = addslashes($email['email']);

    $rash = md5(rand());
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'projeto.pesquisa.tcc.positivo@gmail.com';
        $mail->Password = '@faculdadepositivo123';
        $mail->Port = 587;

        $mail->setFrom('projeto.pesquisa.tcc.positivo@gmail.com');
        $mail->addAddress($send_email);

        $mail->isHTML(true);
        $mail->Subject = "Sistema de Pesquisas < Recuperar senha > ";
        $mail->Body = "<h2> Olá, estamos lhe convidando para participar de uma pesquisa. </h2>
        <p>Acesse este link <a href='".sitedir."?pesquisa-fechada.php&email=$send_email'>".sitedir."?pesquisa-fechada.php&email=$send_email</a></p>";
        $mail->AltBody = 'chegou email altbody';

        if($mail->send()) {
            echo 'email enviado com sucesso';
            $mail->ClearAddresses();
            $_SESSION['pesquinsa_cadastrada'] = true;
            echo '<script type="text/javascript">window.location = "../../View/pesquisa/cadastrar-pesquisa.php"</script>';
        }else{
            echo 'email nao enviado';
            $_SESSION['pesquinsa_cadastrada'] = false;
            header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
        }
    
    }catch (Exception $e){
        echo "erro ao enviar mensagem: {$mail->ErrorInfo}";
        $_SESSION['pesquinsa_cadastrada'] = false;
        header("Location: ../../View/pesquisa/cadastrar-pesquisa.php");
    }    
    endforeach;
}
?>