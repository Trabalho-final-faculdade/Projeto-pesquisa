<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class SenhaRecuperada {

  private $id, $email, $hash, $utilizado;

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

  public function getHash() {
    return $this->hash;
  }

  public function setHash($hash) {
    $this->hash = $hash;
  }

  public function getUtilizado() {
    return $this->utilizado;
  }

  public function setUtilizado($utilizado) {
    $this->utilizado = $utilizado;
  }
}