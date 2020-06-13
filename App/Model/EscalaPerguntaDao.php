<?php

namespace App\Model;
require_once "Conexao.php";


class EscalaPerguntaDao {

  public function create($pergunta_id, $escala_descricao) {
    global $pdo;
    $sql = 'INSERT INTO escala_perguntas (id, pergunta_id, escala_descricao) VALUES(default, :pergunta_id, :escala_descricao)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pergunta_id', $pergunta_id);
    $stmt->bindValue('escala_descricao', $escala_descricao);

    $stmt->execute();
  }

  public function read($pergunta_id) {
    global $pdo;
    $sql = "Select * from escala_perguntas where pergunta_id = :pergunta_id";
    $sql = $pdo->prepare($sql);
    $sql->bindValue('pergunta_id', $pergunta_id);

    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;
  }

  public function update($email, $pesquisa_id){
    global $pdo;
    $sql = 'UPDATE enviar_pesquisas SET respondida = true WHERE email = :email and pesquisa_id = :pesquisa_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('email', $email);
    $stmt->bindValue('pesquisa_id', $pesquisa_id);

    $stmt->execute();
  }

  public function resultado_por_resposta($pergunta_id, $resposta_id){
    global $pdo;
    $sql = 'SELECT *, (select count(*) from questionarios q where q.escala_id = e.id and q.pergunta_id = e.pergunta_id and q.resposta_id = :resposta_id) as quantidade from escala_perguntas e where pergunta_id = :pergunta_id;';

    $sql = $pdo->prepare($sql);
    $sql->bindValue('pergunta_id', $pergunta_id);
    $sql->bindValue('resposta_id', $resposta_id);

    $sql->execute();

    if($sql->rowCount() > 0):
      $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;
  }

}