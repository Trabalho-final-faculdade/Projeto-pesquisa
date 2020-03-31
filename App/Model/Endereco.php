<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Endereco {

  private $id, $rua, $numero, $cidade, $estado, $pais, $cep;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getRua() {
    return $this->rua;
  }

  public function setRua($rua) {
    $this->rua = $rua;
  }

  public function getNumero() {
    return $this->numero;
  }

  public function setNumero() {
    $this->numero = $numero;
  }

  public function getCidade() {
    return $this->cidade;
  }

  public function setCidade() {
    $this->cidade = $cidade;
  }

  public function getEstado() {
    return $this->estado;
  }

  public function setEstado() {
    $this->estado = $estado;
  }

  public function getPais() {
    return $this->pais;
  }

  public function setPais() {
    $this->pais = $pai;
  }

  public function getCep() {
    return $this->cep;
  }

  public function setCep() {
    $this->cep = $cep;
  }
