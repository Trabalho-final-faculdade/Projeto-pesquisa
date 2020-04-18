<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Resposta {

  private $id, $resposta, $pergunta_id;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getResposta() {
    return $this->resposta;
  }

  public function setResposta($resposta) {
    $this->resposta = $resposta;
  }

  public function getPerguntaId() {
    return $this->pergunta_id;
  }

  public function setPerguntaID($pergunta_id) {
    $this->pergunta_id = $pergunta_id;
  }
}