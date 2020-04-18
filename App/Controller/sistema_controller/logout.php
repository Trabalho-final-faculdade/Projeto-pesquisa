<?php
session_start();
unset($_SESSION['id']);
  header("Location: ../../View/sistema/tela-login.php");
?>
