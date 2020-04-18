<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Empresa {

  private $id, $razao_social, $cnpj, $proprietario_id, $endereco, $complemento, $cidade, $estado, $pais, $cep;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getRazaoSocial() {
    return $this->razao_social;
  }

  public function setRazaoSocial($razao_social) {
    $this->razao_social = $razao_social;
  }

  public function getCnpj() {
    return $this->cnpj;
  }

  public function setCnpj($cnpj) {
    $this->cnpj = $cnpj;
  }

  public function getProprietarioId() {
    return $this->proprietario_id;
  }

  public function setProprietarioId($proprietario_id) {
    $this->proprietario_id = $proprietario_id;
  }

  public function getEndereco() {
    return $this->endereco;
  }

  public function setEndereco($endereco) {
    $this->endereco = $endereco;
  }

  public function getComplemento() {
    return $this->complemento;
  }

  public function setComplemento($complemento) {
    $this->complemento = $complemento;
  }

  public function getCidade() {
    return $this->cidade;
  }

  public function setCidade($cidade) {
    $this->cidade = $cidade;
  }

  public function getEstado() {
    return $this->estado;
  }

  public function setEstado($estado) {
    $this->estado = $estado;
  }

  public function getPais() {
    return $this->pais;
  }

  public function setPais($pais) {
    $this->pais = $pais;
  }

  public function getCep() {
    return $this->cep;
  }

  public function setCep($cep) {
    $this->cep = $cep;
  }
}