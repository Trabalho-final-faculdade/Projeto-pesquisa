<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Usuario {

  private $id, $nome, $cpf, $email, $senha, $endereco_id, $telefone_id, $nivel_acesso_id, $empresa_id;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getNome() {
    return $this->nome;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }

  public function getCpf() {
    return $this->cpf;
  }

  public function setCpf($cpf) {
    $this->cpf = $cpf;
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

  public function getEnderecoId() {
    return $this->endereco_id;
  }

  public function setEnderecoID($endereco_id) {
    $this->endereco_id = $endereco_id;
  }

  public function getTelefoneId() {
    return $this->telefone_id;
  }

  public function setTelefoneId($telefone_id) {
    $this->telefone = $telefone_id;
  }

  public function getNivelAcessoId() {
    return $this->nivel_acesso_id;
  }

  public function setNivelAcessoId($nivel_acesso_id) {
    $this->nivel_acesso_id = $nivel_acesso_id;
  }

  public function getEmpresaId() {
    return $this->empresa_id;
  }

  public function setEmpresaId($empresa_id) {
    $this->empresa_id = $empresa_id;
  }

  public function traz_usuario_logado($id) {
    global $pdo;

      $sql = "Select * from usuarios where id = :id";
      $sql = $pdo->prepare($sql);

      $sql->bindValue("id", $id);
      $sql->execute();

       if($sql->rowCount() > 0)
       {
          return $resultado = $sql->fetch();

        }else
        {
          return false;
        }

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
