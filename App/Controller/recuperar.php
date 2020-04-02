<?php

  function verifica_dados($con){
    if(isset($_POST['env']) && $_POST['env'] == "form") {
      $sql = "SELECT * FROM usuarios WHERE email = :email";
      $stmt = $con->prepare($sql);
      $stmt->bindValue("email", $_POST['email']);

      $stmt->execute();
      if($stmt->rowCount() > 0){
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        add_dados_recover($con, $dados[0]['email']);
      }else{
        $_SESSION["nao_encontrado"] = true;
      }
    }
  }

  function add_dados_recover($con, $email){
    $hash = md5(rand());
    $sql = $con->prepare("INSERT INTO senhas_recuperadas (email, hash) VALUES (:email, :hash)");
    $sql->bindValue("email", $email);
    $sql->bindValue("hash", $hash);

    $sql->execute();

    if($sql->rowCount() > 0){
      enviar_email($con, $email, $hash);
    }

  }

  function enviar_email($con, $email, $md5){
    $to = $email;
    $subject = "My subject";
    $txt = "Hello world!";
    $headers = "From: webmaster@example.com" . "\r\n" .
    "CC: somebodyelse@example.com";

    mail($to,$subject,$txt,$headers);
  }
?>
