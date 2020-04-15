<?php

namespace App\Model;

class PerguntaDao {

  public function create(Pergunta $p) {
    global $pdo;
    $sql = 'INSERT INTO perguntas VALUES(default, :pergunta, :tipo, :pesquisa_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pergunta', $p->getPergunta());
    $stmt->bindValue('tipo', $p->getTipoPergunta());
    $stmt->bindValue('pesquisa_id', $p->getPesquisaId());
   
    $stmt->execute();
    return true;

  }

  public function buscar_pergunta_nome($pergunta) {
    global $pdo;
    $sql = 'SELECT * FROM perguntas where pergunta = :pergunta ORDER BY pergunta DESC limit 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pergunta', $pergunta);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function buscar_pergunta($id) {
    global $pdo;
    $sql = 'SELECT * FROM perguntas where id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function buscar_pergunta_pesquisa($id) {
    global $pdo;
    $sql = 'SELECT * FROM perguntas where pesquisa_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  }

  public function update(Pergunta $pergunta) {
    global $pdo;
    $sql = 'UPDATE perguntas SET pergunta = :pergunta, tipo = :tipo_pergunta WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $pergunta->getId());
    $stmt->bindValue('pergunta', $pergunta->getPergunta());
    $stmt->bindValue('tipo_pergunta', $pergunta->getTipoPergunta());

    $stmt->execute();
  }

  public function delete($id) {
    // $sql = 'DELETE FROM usuarios WHERE id = ?';
    //
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->bindValue(1, $id->getId());
    // $stmt->execute();
  }
}
