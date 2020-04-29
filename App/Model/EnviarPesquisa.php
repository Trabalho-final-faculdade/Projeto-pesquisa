<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class EnviarPesquisa {

  private $id, $pesquisa_id, $email;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getPesquisaId() {
    return $this->pesquisa_id;
  }

  public function setPesquisaId($pesquisa_id) {
    $this->pesquisa_id = $pesquisa_id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }
}