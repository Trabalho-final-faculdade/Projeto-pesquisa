<?php

namespace App\Model;
require_once "Conexao.php";
class QuestionarioDao {

  public function create(Questionario $q) {
    global $pdo;
    $sql = 'INSERT INTO questionarios VALUES(default, :pesquisa_id, :pergunta_id, :resposta_id, :operador_id, :entrevistado_email)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pesquisa_id', $q->getPesquisaId());
    $stmt->bindValue('pergunta_id', $q->getPerguntaId());
    $stmt->bindValue('resposta_id', $q->getRespostaId());
    $stmt->bindValue('operador_id', $q->getOperadorId());
    $stmt->bindValue('entrevistado_email', $q->getEntrevistadoEmail());
    
    $stmt->execute();

    return true;

  }

  public function read($id){
    global $pdo;
    $sql = 'SELECT * FROM questionarios WHERE pergunta_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  } 

  public function verifica_usuario_ja_respondeu($pesquisa, $email){
    global $pdo;
    $sql = 'SELECT * FROM questionarios WHERE pesquisa_id = :pesquisa_id and entrevistado_email = :entrevistado_email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pesquisa_id', $pesquisa);
    $stmt->bindValue('entrevistado_email', $email);

    $stmt->execute();

    if($stmt->rowCount() > 0){
      return true;
    }else{
      return false;
    }

  } 
  public function buscar_questionario_pesquisa($id){
    global $pdo;
    $sql = 'SELECT * FROM questionarios WHERE pesquisa_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;

  } 
}

?>