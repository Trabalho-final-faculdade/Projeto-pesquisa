<?php

namespace App\Model;

require_once "../../Model/Conexao.php";
header('Content-Type: text/html; charset=utf-8');

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
    $sql = $pdo->prepare($sql);
    $sql->bindValue('id', $id);

    $sql->execute();

    if($sql->rowCount() > 0):
      $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
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

  public function resultado_por_pergunta($id) {
    global $pdo;
    $sql = 'SELECT count(*) AS quantidade, resposta_id, respostas.resposta FROM questionarios JOIN respostas ON respostas.id = questionarios.resposta_id WHERE questionarios.pergunta_id = :id GROUP BY questionarios.resposta_id';
    $sql = $pdo->prepare($sql);
    $sql->bindValue('id', $id);

    $sql->execute();

    if($sql->rowCount() > 0):
      $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;
  }
  public function delete($id) {
  //   $sql = 'DELETE FROM usuarios WHERE id = ?';
  //
  //   $stmt = Conexao::getConn()->prepare($sql);
  //   $stmt->bindValue(1, $id->getId());
  //   $stmt->execute();
  }
}
