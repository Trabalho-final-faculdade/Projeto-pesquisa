<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class NivelDeAcesso {

  private $id, $nivel;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getNivel() {
    return $this->nivel;
  }

  public function setNivel($nivel) {
    $this->nivel = $nivel;
  }
}