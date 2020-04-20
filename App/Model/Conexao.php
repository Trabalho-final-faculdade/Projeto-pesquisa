<?php


  $localhost = "us-cdbr-iron-east-01.cleardb.net";
  $user = "ba1afdaa9340aa";
  $passw = "10ebf093";
  $banco = "heroku_bdc5eb13438a9c1";

  global $pdo;
  try{
    $pdo = new PDO("mysql:dbname=".$banco."; host=".$localhost, $user, $passw);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
  }


?>
