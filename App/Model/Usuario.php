<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Usuario {

  private $id, $email, $senha;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getSenha() {
    return $this->senha;
  }

  public function setSenha($senha) {
    $this->senha = $senha;
  }

  public function logar($email, $senha) {
    global $pdo;

      $sql = "Select * from usuarios where email = :email and senha = :senha";
      $sql = $pdo->prepare($sql);

      $sql->bindValue("email", $email);
      $sql->bindValue("senha", md5($senha));
      $sql->execute();

       if($sql->rowCount() > 0){
          $resultado = $sql->fetch();
          $_SESSION['id'] = $resultado['id'];
          return true;
        }else
        {
          return false;
        }

    }

}
