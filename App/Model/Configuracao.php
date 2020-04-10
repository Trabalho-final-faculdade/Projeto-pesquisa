<?php

namespace App\Model;
require_once "../Model/Conexao.php";

class Configuracao {

  private $id, $empresa_id, $cadastro, $visualizar_dados_usuario, $visualizar_dados_pesquisa, $visualizar_resultado_pesquisa, $visualizar_grafico, $gerar_relatorios;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getCadastro() {
    return $this->cadastro;
  }

  public function setCadastro($cadastro) {
    $this->cadastro = $cadastro;
  }

  public function getEmpresa_id() {
    return $this->empresa_id;
  }

  public function setEmpresaId($empresa_id) {
    $this->empresa_id = $empresa_id;
  }

   public function getVisualizarDadosUsuarios() {
    return $this->visualizar_dados_usuario;
  }

  public function setVisualizarDadosUsuario($visualizar_dados_usuario) {
    $this->visualizar_dados_usuario = $visualizar_dados_usuario;
  }

  public function getVisualizarDadosPesquisa() {
    return $this->visualizar_dados_pesquisa;
  }

  public function setVisualizarDadosPesquisa($visualizar_dados_pesquisa) {
    $this->visualizar_dados_pesquisa = $visualizar_dados_pesquisa;
  }

  public function getVisualizarResultadoPesquisa() {
    return $this->visualizar_resultado_pesquisa;
  }

  public function setVisualizarResultadoPesquisa($visualizar_resultado_pesquisa) {
    $this->visualizar_resultado_pesquisa = $visualizar_resultado_pesquisa;
  }

  public function getVisualizarGrafico() {
    return $this->visualizar_grafico;
  }

  public function setVisualizarGrafico($visualizar_grafico) {
    $this->visualizar_grafico = $visualizar_grafico;
  }

  public function getGerarRelatorio() {
    return $this->gerar_relatorios;
  }

  public function setGerarRelatorio($gerar_relatorios) {
    $this->gerar_relatorios = $gerar_relatorios;
  }




}