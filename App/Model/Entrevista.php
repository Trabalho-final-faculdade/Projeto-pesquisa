<?php

namespace App\Model;
require_once "../../Model/Conexao.php";

class Entrevista {

  private $id, $pesquisa_id, $usuario_pesquisador_id, $usuario_pesquisado_id, $resposta_id;

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

  public function getUsuarioPesquisadorId() {
    return $this->usuario_pesquisador;
  }

  public function setUsuarioPesquisadorId($usuario_pesquisador_id) {
    $this->usuario_pesquisador = $usuario_pesquisador_id;
  }

  public function getUsuarioPesquisadoId() {
    return $this->usuario_pesquisado;
  }

  public function setUsuarioPesquisadoId($usuario_pesquisado_id) {
    $this->usuario_pesquisado = $usuario_pesquisado_id;
  }

  public function getRespostaId() {
    return $this->resposta_id;
  }

  public function setRespostaId($resposta_id) {
    $this->resposta_id = $resposta_id;
  }
