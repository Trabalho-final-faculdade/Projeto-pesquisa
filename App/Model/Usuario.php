<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Usuario {

  private $id, $nome, $cpf, $data_nascimento, $genero, $email, $senha, $endereco_id, $telefone_id, $nivel_acesso_id, $empresa_id, $criado_em, $deletado_em;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getNascimento() {
    return $this->data_nascimento;
  }

  public function setNascimento($data_nascimento) {
    $this->data_nascimento = $data_nascimento;
  }

  public function getGenero() {
    return $this->genero;
  }

  public function setGenero($genero) {
    $this->genero = $genero;
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
    $this->telefone_id = $telefone_id;
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

  public function getCriadoEm() {
    return $this->criado_em;
  }

  public function setCriadoEm($criado_em) {
    $this->criado_em = $criado_em;
  }

  public function getDeletadoEm() {
    return $this->deletado_em;
  }

  public function setDeletadoEm($deletado_em) {
    $this->deletado_em = $deletado_em;
  }

  public function logar($email, $senha) {
    global $pdo;

      $sql = "Select * from usuarios where email = :email and senha = :senha and deletado_em is null";
      $sql = $pdo->prepare($sql);

      $sql->bindValue("email", $email);
      $sql->bindValue("senha", md5($senha));
      $sql->execute();

       if($sql->rowCount() > 0){
          $resultado = $sql->fetch();
          $_SESSION['id'] = $resultado['id'];
          $_SESSION['empresa_id'] = $resultado['empresa_id'];
          return true;
        }else
        {
          return false;
        }

    }
  
}
