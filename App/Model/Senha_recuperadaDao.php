<?php

namespace App\Model;

require_once "Conexao.php";


class SenhaRecuperadaDao {

  public function create($email, $rash) {
    global $pdo;
      $utilizado = 0;
      $sql = 'INSERT INTO senhas_recuperadas VALUES(default, :email, :rash, :utilizado)';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('email', $email);
      $stmt->bindValue('rash', $rash);
      $stmt->bindValue('utilizado', $utilizado);

      $stmt->execute();
      return true;
  }

  public function read($rash) {
    $utilizado = 0;
    global $pdo;
    $sql = 'SELECT * FROM senhas_recuperadas where hash = :rash and utilizado = :utilizado';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('rash', $rash);
    $stmt->bindValue('utilizado', $utilizado);

    $stmt->execute();

    if($stmt->rowCount() > 0):
      $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
       return $resultado;
    endif;
  }

  public function alterar_status($email) {
      global $pdo;
      $sql = 'UPDATE senhas_recuperadas SET utilizado = :utilizado WHERE email = :email';
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('email', $email);
      $stmt->bindValue('utilizado', 1);
  
      $stmt->execute();
      
      return true;
  }

  public function delete($id) {
  //   $sql = 'DELETE FROM usuarios WHERE id = ?';
  //
  //   $stmt = Conexao::getConn()->prepare($sql);
  //   $stmt->bindValue(1, $id->getId());
  //   $stmt->execute();
  }
}
