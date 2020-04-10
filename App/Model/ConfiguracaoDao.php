<?php

namespace App\Model;
require_once "../Model/Conexao.php";


class ConfiguracaoDao {

  public function create(Configuracao $c) {
    global $pdo;  
    $sql = 'INSERT INTO configuracoes VALUES(default, :empresa_id, :cadastro, :visualizar_dados_usuario, :visualizar_dados_pesquisa, :visualizar_resultado_pesquisa, :visualizar_grafico, :gerar_relatorios)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('empresa_id', $c->getEmpresa_id());
    $stmt->bindValue('cadastro', $c->getCadastro());
    $stmt->bindValue('visualizar_dados_usuario', $c->getVisualizarDadosUsuarios());
    $stmt->bindValue('visualizar_dados_pesquisa', $c->getVisualizarDadosPesquisa());
    $stmt->bindValue('visualizar_resultado_pesquisa', $c->getVisualizarResultadoPesquisa());
    $stmt->bindValue('visualizar_grafico', $c->getVisualizarGrafico());
    $stmt->bindValue('gerar_relatorios', $c->getGerarRelatorio());

    $stmt->execute();
  }

  
  public function read($id) {
    global $pdo;
    $sql = "Select * from configuracoes where empresa_id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("id", $id);
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;
  }

  public function update(Configuracao $c) {
    global $pdo;
    $sql = 'UPDATE configuracoes SET cadastro = :cadastro, visualizar_dados_usuario = :visualizar_dados_usuario, visualizar_dados_pesquisa = :visualizar_dados_pesquisa, visualizar_resultado_pesquisa = :visualizar_resultado_pesquisa, visualizar_grafico = :visualizar_grafico, gerar_relatorios = :gerar_relatorios WHERE empresa_id = :empresa_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('empresa_id', $c->getEmpresa_id());
    $stmt->bindValue('cadastro', $c->getCadastro());
    $stmt->bindValue('visualizar_dados_usuario', $c->getVisualizarDadosUsuarios());
    $stmt->bindValue('visualizar_dados_pesquisa', $c->getVisualizarDadosPesquisa());
    $stmt->bindValue('visualizar_resultado_pesquisa', $c->getVisualizarResultadoPesquisa());
    $stmt->bindValue('visualizar_grafico', $c->getVisualizarGrafico());
    $stmt->bindValue('gerar_relatorios', $c->getGerarRelatorio());

    $stmt->execute();

   
  }

  public function buscar_usuarios($buscar, $valor, $empresa){
    global $pdo;
    if($buscar == 'id'){
        $sql = "SELECT * FROM usuarios WHERE id = :valor AND empresa_id = :empresa";
    }else if($buscar == 'cpf'){
        $sql = "SELECT * FROM usuarios WHERE cpf = :valor AND empresa_id = :empresa";
    }else if($buscar == 'nome'){
        $sql = "SELECT * FROM usuarios WHERE nome like concat('%', :valor, '%') AND empresa_id = :empresa";
    }else if($buscar == 'nivel'){
        $sql = "SELECT * FROM usuarios WHERE nivel_acesso_id = ? AND empresa_id = :empresa";
    }

    $sql = $pdo->prepare($sql);

    $sql->bindValue('valor', $valor);
    $sql->bindValue('empresa', $empresa);

    $sql->execute();

    if($sql->rowCount() > 0){
        $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    }else{
        return false;
    }
  }

  public function delete($id) {
    $sql = 'DELETE FROM usuarios WHERE id = ?';

   
  }
}
