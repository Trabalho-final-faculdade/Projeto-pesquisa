<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Pesquisa {

  private $id, $titulo, $visualizacao_id, $empresa_id;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getTitulo() {
    return $this->titulo;
  }

  public function setTitulo($titulo) {
    $this->titulo = $titulo;
  }

  public function getVisualizacaoId() {
    return $this->visualizacao_id;
  }

  public function setVisualizacaoId($visualizacao_id) {
    $this->visualizacao_id = $visualizacao_id;
  }

  public function getEmpresaId() {
    return $this->empresa_id;
  }

  public function setEmpresaId($empresa_id) {
    $this->empresa_id = $empresa_id;
  }
