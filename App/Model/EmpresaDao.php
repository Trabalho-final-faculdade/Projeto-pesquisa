<?php

namespace App\Model;

require_once "../../Model/Conexao.php";

class EmpresaDao {

  public function create(Empresa $e) {
    global $pdo;
    $sql = 'INSERT INTO empresas (id, razao_social, cnpj, proprietario_id, endereco, complemento, cidade, estado, pais, cep) VALUES(default, :razao_social, :cnpj, :proprietario_id, :endereco, :complemento, :cidade, :estado, :pais, :cep)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('razao_social', $e->getRazaoSocial());
    $stmt->bindValue('cnpj', $e->getCnpj());
    $stmt->bindValue('proprietario_id', $e->getProprietarioId());
    $stmt->bindValue('endereco', $e->getEndereco());
    $stmt->bindValue('complemento', $e->getComplemento());
    $stmt->bindValue('cidade', $e->getCidade());
    $stmt->bindValue('estado', $e->getEstado());
    $stmt->bindValue('pais', $e->getPais());
    $stmt->bindValue('cep', $e->getCep());

    $stmt->execute();
  }

  public function read($id) {
    global $pdo;
    $sql = "Select * from empresas where proprietario_id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("id", $id);
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    endif;
  }

  public function update(Empresa $e) {
    global $pdo;
    $sql = 'UPDATE empresas SET razao_social = :razao_social, cnpj = :cnpj, endereco = :endereco, complemento = :complemento, cidade = :cidade, estado = :estado, pais = :pais, cep = :cep WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('razao_social', $e->getRazaoSocial());
    $stmt->bindValue('cnpj', $e->getCnpj());
    $stmt->bindValue('endereco', $e->getEndereco());
    $stmt->bindValue('complemento', $e->getComplemento());
    $stmt->bindValue('cidade', $e->getCidade());
    $stmt->bindValue('estado', $e->getEstado());
    $stmt->bindValue('pais', $e->getPais());
    $stmt->bindValue('cep', $e->getCep());
    $stmt->bindValue('id', $e->getId());

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
