<?php

namespace App\Model;

require_once "../../Model/Conexao.php";


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

  public function buscar_pesquisas($valor, $buscar) {
    global $pdo;
    if($buscar == 'id'){
        $sql = "SELECT * FROM pesquisas WHERE id = :valor";
    }else if($buscar == 'periodo'){
        $sql = "SELECT * FROM pesquisas WHERE cpf = :valor";
    }else if($buscar == 'titulo'){
        $sql = "SELECT * FROM pesquisas WHERE titulo like concat('%', :valor, '%')";
    }

    $sql = $pdo->prepare($sql);

    $sql->bindValue('valor', $valor);

    $sql->execute();

    if($sql->rowCount() > 0){
        $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    }else{
        return false;
    }
  }

  public function buscar_pesquisas_estado($status) {
    global $pdo;
    $sql = "SELECT * FROM pesquisas WHERE status = :status";
    
    $sql = $pdo->prepare($sql);

    $sql->bindValue('status', $status);

    $sql->execute();

    if($sql->rowCount() > 0){
        $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    }else{
        return false;
    }
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

  public function buscar_pesquisas_titulo($id){
    global $pdo;
    $sql = 'SELECT * FROM pesquisas where titulo = :titulo ORDER BY titulo DESC limit 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('titulo', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function retornar_numero_pesquisas_realizadas(){
    global $pdo;
    $sql = 'select pesquisa_id, count(DISTINCT entrevistado_id) from questionarios group by pesquisa_id';
    $stmt = $pdo->prepare($sql);

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
