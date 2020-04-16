<?php

namespace App\Model;

class QuestionarioDao {

  public function create(Questionario $q) {
    global $pdo;
    $sql = 'INSERT INTO questionarios VALUES(default, :pesquisa_id, :pergunta_id, :resposta_id, :operador_id, :entrevistado_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pesquisa_id', $q->getPesquisaId());
    $stmt->bindValue('pergunta_id', $q->getPerguntaId());
    $stmt->bindValue('resposta_id', $q->getRespostaId());
    $stmt->bindValue('operador_id', $q->getOperadorId());
    $stmt->bindValue('entrevistado_id', $q->getEntrevistadoId());
    
    $stmt->execute();

    return true;

  }
}

?>