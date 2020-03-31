<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Pergunta {

  private $id, $pergunta, $empresa_id;

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

  public function getEmpresaId() {
    return $this->empresa;
  }

  public function setEmpresaId($empresa_id) {
    $this->empresa = $empresa_id;
  }
