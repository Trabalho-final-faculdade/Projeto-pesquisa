<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Pesquisa {

  private $id, $titulo, $data_inicial, $data_final, $observacao, $status;

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

  public function getDataInicial() {
    return $this->data_inicial;
  }

  public function setDataInicial($data_inicial) {
    $this->data_inicial = $data_inicial;
  }

  public function getDataFinal() {
    return $this->data_final;
  }

  public function setDataFinal($data_final) {
    $this->data_final = $data_final;
  }

  public function getObservacao() {
    return $this->observacao;
  }

  public function setObservacao($observacao) {
    $this->observacao = $observacao;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
  }
}