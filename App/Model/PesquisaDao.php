<?php

namespace App\Model;

class PesquisaDao {

  public function create(Pesquisa $p) {
    global $pdo;
    $sql = 'INSERT INTO pesquisas VALUES(default, :titulo, DATE(:data_inicial), DATE(:data_final), :observacao, :status)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('titulo', $p->getTitulo());
    $stmt->bindValue('data_inicial', $p->getDataInicial());
    $stmt->bindValue('data_final', $p->getDataFinal());
    $stmt->bindValue('observacao', $p->getObservacao());
    $stmt->bindValue('status', $p->getStatus());
    
    $stmt->execute();

    return true;

  }

  public function buscar_pesquisas($status) {
    global $pdo;
    $sql = 'SELECT * FROM pesquisas where status = :status';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('status', $status);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function read($id){
    global $pdo;
    $sql = 'SELECT * FROM pesquisas where id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  } 

  public function update(Pesquisa $p) {
    global $pdo;
    $sql = 'UPDATE pesquisas SET titulo = :titulo,  data_inicial = :data_inicial, data_final = :data_final, status = :status , observacao = :observacao WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('status', $p->getStatus());
    $stmt->bindValue('titulo', $p->getTitulo());
    $stmt->bindValue('data_inicial', $p->getDataInicial());
    $stmt->bindValue('data_final', $p->getDataFinal());
    $stmt->bindValue('observacao', $p->getObservacao());
    $stmt->bindValue('id', $p->getId());

    $stmt->execute();

   return true;

  }

  public function delete($id) {
    // $sql = 'DELETE FROM usuarios WHERE id = ?';
    //
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->bindValue(1, $id->getId());
    // $stmt->execute();
  }
}
