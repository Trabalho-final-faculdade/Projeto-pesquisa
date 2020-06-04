<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class EscalaPergunta {

  private $id, $pergunta_id, $escala_descricao;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getPerguntaId() {
    return $this->pergunta_id;
  }

  public function setPerguntaId($pergunta_id) {
    $this->pergunta_id = $pergunta_id;
  }

  public function getEscalaDescricao() {
    return $this->escala_descricao;
  }

  public function setEscalaDescricao($escala_descricao) {
    $this->escala_descricao = $escala_descricao;
  }
}