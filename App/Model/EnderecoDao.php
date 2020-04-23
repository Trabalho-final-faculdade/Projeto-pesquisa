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
   

  }

  public function update(Endereco $p, $endereco_id) {
    global $pdo;
    $sql = 'UPDATE enderecos SET rua = :rua, cep = :cep, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado, pais = :pais WHERE id = :endereco_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('rua', $p->getRua());
    $stmt->bindValue('cep', $p->getCep());
    $stmt->bindValue('numero', $p->getNumero());
    $stmt->bindValue('bairro', $p->getBairro());
    $stmt->bindValue('complemento', $p->getComplemento());
    $stmt->bindValue('cidade', $p->getCidade());
    $stmt->bindValue('estado', $p->getEstado());
    $stmt->bindValue('pais', $p->getPais());
    $stmt->bindValue('cep', $p->getCep());
    $stmt->bindValue('endereco_id', $endereco_id);

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
