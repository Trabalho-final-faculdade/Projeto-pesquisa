<?php

namespace App\Model;

require_once "Conexao.php";


class PesquisaDao {

  public function create(Pesquisa $p) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y/m/d');
    global $pdo;
    $sql = 'INSERT INTO pesquisas VALUES(default, :titulo, :observacao, :status, :criada_em, :fechada)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('titulo', $p->getTitulo());
    $stmt->bindValue('observacao', $p->getObservacao());
    $stmt->bindValue('status', $p->getStatus());
    $stmt->bindValue('criada_em', $data);
    $stmt->bindValue('fechada', $p->getFechada());
    
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
        return 0;
    }
  }

  public function buscar_pesquisas_estado_aberta($status) {
    global $pdo;
    $sql = "SELECT * FROM pesquisas WHERE status = :status AND fechada = false";
    
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
    $sql = 'SELECT * FROM pesquisas WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  } 


  public function buscar_finalizadas($id){
    global $pdo;
    $sql = 'SELECT * FROM questionarios WHERE pesquisa_id = :id  AND concluido = 1 GROUP BY entrevistado_email;';
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
    $sql = 'SELECT * FROM questionarios WHERE concluido = 1 GROUP BY entrevistado_email;';
    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function update(Pesquisa $p) {
    global $pdo;
    $sql = 'UPDATE pesquisas SET titulo = :titulo, status = :status , observacao = :observacao WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('status', $p->getStatus());
    $stmt->bindValue('titulo', $p->getTitulo());
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
