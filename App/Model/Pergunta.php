<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Pergunta {

  private $id, $pergunta, $tipo_pergunta, $pesquisa_id;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getPergunta() {
    return $this->pergunta;
  }

  public function setPergunta($pergunta) {
    $this->pergunta = $pergunta;
  }

  public function getTipoPergunta() {
    return $this->tipo_pergunta;
  }

  public function setTipoPergunta($tipo_pergunta) {
    $this->tipo_pergunta = $tipo_pergunta;
  }

  public function getPesquisaId() {
    return $this->pesquisa_id;
  }

  public function setPesquisaId($pesquisa_id) {
    $this->pesquisa_id = $pesquisa_id;
  }
}