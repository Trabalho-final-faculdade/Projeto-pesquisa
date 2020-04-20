<?php

namespace App\Model;

require_once "../../Model/Conexao.php";


class EnderecoDao {

  public function create(Usuario $u) {
    // $sql = 'INSERT INTO usuarios (usuario, senha) VALUES(?,MD5(?))';
    //
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->bindValue(1, $p->getUsuario());
    // $stmt->bindValue(2, $p->getSenha());
    // $stmt->execute();

  }

  public function read() {
    // $sql = 'SELECT usuario from usuarios';
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->execute();
    //
    // if($stmt->rowCount() > 0):
    //   $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //   return $resultado;
    // endif;

  }

  public function update(Usuario $p) {
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
    // $sql = 'DELETE FROM usuarios WHERE id = ?';
    //
    // $stmt = Conexao::getConn()->prepare($sql);
    // $stmt->bindValue(1, $id->getId());
    // $stmt->execute();
  }
}
