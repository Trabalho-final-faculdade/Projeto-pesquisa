<?php

namespace App\Model;

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

    // $sql = 'UPDATE usuarios SET usuario = ?, senha = MD5(?) WHERE id =?';
    //
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->bindValue(1, $p->getUsuario());
    // $stmt->bindValue(2, $p->getSenha());
    // $stmt->bindValue(3, $p->getId());
    //
    // $stmt->execute();
  }

  public function delete($id) {
  //   $sql = 'DELETE FROM usuarios WHERE id = ?';
  //
  //   $stmt = Conexao::getConn()->prepare($sql);
  //   $stmt->bindValue(1, $id->getId());
  //   $stmt->execute();
  }
}
