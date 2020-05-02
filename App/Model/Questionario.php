<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Questionario {

  private $id, $pesquisa_id, $pergunta_id, $resposta_id, $operador_id, $entrevistado_email;

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

  public function getPesquisaId() {
    return $this->pesquisa_id;
  }

  public function setPesquisaId($pesquisa_id) {
    $this->pesquisa_id = $pesquisa_id;
  }

  public function getRespostaId() {
    return $this->resposta_id;
  }

  public function setRespostaId($resposta_id) {
    $this->resposta_id = $resposta_id;
  }

  public function getOperadorId() {
    return $this->operador_id;
  }

  public function setOperadorId($operador_id) {
    $this->operador_id = $operador_id;
  }

  public function getEntrevistadoEmail() {
    return $this->entrevistado_email;
  }

  public function setEntrevistadoEmail($entrevistado_email) {
    $this->entrevistado_email = $entrevistado_email;
  }
}