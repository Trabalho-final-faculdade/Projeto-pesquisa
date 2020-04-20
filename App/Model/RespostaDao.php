<?php

namespace App\Model;

require_once "../../Model/Conexao.php";


class RespostaDao {

  public function create($resposta, $pergunta_id) {
    global $pdo;
    $sql = 'INSERT INTO respostas VALUES(default, :resposta, :pergunta_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('resposta', $resposta);
    $stmt->bindValue('pergunta_id', $pergunta_id);
    
    $stmt->execute();

  }

  public function read($id) {
    global $pdo;
    $sql = 'SELECT * FROM respostas where pergunta_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;
  }

  public function update($p) {
    foreach($p as $id => $resposta):
      global $pdo;
      $sql = 'UPDATE respostas SET resposta = :resposta WHERE id = :id';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('id', $id);
      $stmt->bindValue('resposta', $resposta);
  
      $stmt->execute();

      
    endforeach;    
    return true;
  }

  public function delete($id) {
  //   $sql = 'DELETE FROM usuarios WHERE id = ?';
  //
  //   $stmt = Conexao::getConn()->prepare($sql);
  //   $stmt->bindValue(1, $id->getId());
  //   $stmt->execute();
  }
}
