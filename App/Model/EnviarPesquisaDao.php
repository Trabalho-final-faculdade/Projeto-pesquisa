<?php

namespace App\Model;
require_once "Conexao.php";


class EnviarPesquisaDao {

  public function create($pesquisa_id, $email) {
    global $pdo;
    $sql = 'INSERT INTO enviar_pesquisas (id, pesquisa_id, email) VALUES(default, :pesquisa_id, :email)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('pesquisa_id', $pesquisa_id);
    $stmt->bindValue('email', $email);

    $stmt->execute();
  }

  public function read($pesquisa_id) {
    global $pdo;
    $sql = "Select * from enviar_pesquisas where pesquisa_id = :pesquisa_id";
    $sql = $pdo->prepare($sql);
    $sql->bindValue('pesquisa_id', $pesquisa_id);

    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;
  }

  public function buscar_pesquisas_nao_realizadas($email) {
    global $pdo;
    $sql = "Select * from enviar_pesquisas where email = :email and respondida = false";
    $sql = $pdo->prepare($sql);
    $sql->bindValue('email', $email);

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

}