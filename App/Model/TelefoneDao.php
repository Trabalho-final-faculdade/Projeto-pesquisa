<?php

namespace App\Model;

class TelefoneDao {

  public function create(Telefone $t) {
    global $pdo;
    $sql = 'INSERT INTO telefones (id, telefone, celular) VALUES(default, :telefone, :celular)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('telefone', $t->getTelefone());
    $stmt->bindValue('celular', $t->getCelular());
    
    $stmt->execute();

  }

  public function salvar_telefone(Telefone $t) {
    global $pdo;
    $sql = "Select id from telefones where telefone = :telefone and celular = :celular";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("telefone", $t->getTelefone());
    $sql->bindValue("celular", $t->getCelular());
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;

  }

  public function buscar_telefone($id) {
    global $pdo;
    $sql = "Select * from telefones where id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("id", $id);
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;

  }

  public function update(Telefone $t, Usuario $u) {
    global $pdo;
    $sql = 'UPDATE telefones SET telefone = :telefone, celular = :celular WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('telefone', $t->getTelefone());
    $stmt->bindValue('celular', $t->getCelular());
    $stmt->bindValue('id', $u->getTelefoneId());

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
