<?php
session_start();
unset($_SESSION['id']);
  header("Location: ../View/tela-login.php");
?>
