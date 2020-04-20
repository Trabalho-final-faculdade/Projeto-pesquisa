<?php

namespace App\Model;
require_once "../../Model/Conexao.php";


class NivelDeAcessoDao {

  public function create(Usuario $u) {
   
  }

  public function read() {
    global $pdo;
    $sql = "Select * from nivel_acesso";
    $sql = $pdo->prepare($sql);

    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;
  }

  public function buscar_nivel($u) {
    global $pdo;
    $sql = "Select * from nivel_acesso where id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue('id', $u);

    $sql->execute();

    if($sql->rowCount() > 0){
        $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    }else{
        return false;
    }
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
