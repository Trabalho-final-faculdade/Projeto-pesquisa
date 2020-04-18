<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Telefone {

  private $id, $telefone, $celular;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getTelefone() {
    return $this->telefone;
  }

  public function setTelefone($telefone) {
    $this->telefone = $telefone;
  }

  public function getCelular() {
    return $this->celular;
  }

  public function setCelular($celular) {
    $this->celular = $celular;
  }
}