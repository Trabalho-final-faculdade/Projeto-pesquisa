<?php

namespace App\Model;
require_once "../Model/Conexao.php";


class UsuarioDao {

  public function create(Usuario $u) {
    global $pdo;
    $sql = 'INSERT INTO usuarios (id, nome, cpf, data_nascimento, genero, email, senha, endereco_id, telefone_id, nivel_acesso_id, empresa_id) VALUES(default, :nome, :cpf, DATE( :data_nascimento ), :genero, :email, MD5(:senha), :endereco_id, :telefone_id, :nivelAcesso_id, :empresa_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('nome', $u->getNome());
    $stmt->bindValue('cpf', $u->getCpf());
    $stmt->bindValue('data_nascimento', $u->getNascimento());
    $stmt->bindValue('genero', $u->getGenero());
    $stmt->bindValue('email', $u->getEmail());
    $stmt->bindValue('senha', $u->getSenha());
    $stmt->bindValue('endereco_id', $u->getEnderecoId());
    $stmt->bindValue('telefone_id', $u->getTelefoneId());
    $stmt->bindValue('nivelAcesso_id', $u->getNivelAcessoId());
    $stmt->bindValue('empresa_id', $u->getEmpresaId());

    $stmt->execute();
  }

  
  public function read($id) {
    global $pdo;
    $sql = "Select * from usuarios where id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("id", $id);
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
      endif;
  }

  public function buscar_entrevistado($valor, $empresa) {
    global $pdo;
    $sql = "SELECT * FROM usuarios WHERE cpf = :valor AND empresa_id = :empresa_id AND nivel_acesso_id = 5";
    $sql = $pdo->prepare($sql);

    $sql->bindValue("valor", $valor);
    $sql->bindValue("empresa_id", $empresa);
    $sql->execute();

     if($sql->rowCount() > 0):
       $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
      endif;
  }

  public function update(Usuario $u) {
    global $pdo;
    $sql = 'UPDATE usuarios SET nome = :nome, cpf = :cpf, data_nascimento = DATE(:data_nascimento), genero = :genero, email = :email, senha = MD5(:senha), nivel_acesso_id = :nivelAcesso_id WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('nome', $u->getNome());
    $stmt->bindValue('cpf', $u->getCpf());
    $stmt->bindValue('data_nascimento', $u->getNascimento());
    $stmt->bindValue('genero', $u->getGenero());
    $stmt->bindValue('email', $u->getEmail());
    $stmt->bindValue('senha', $u->getSenha());
    $stmt->bindValue('nivelAcesso_id', $u->getNivelAcessoId());
    $stmt->bindValue('id', $u->getId());

    $stmt->execute();

   
  }

  public function buscar_usuarios($buscar, $valor, $empresa){
    global $pdo;
    if($buscar == 'id'){
        $sql = "SELECT * FROM usuarios WHERE id = :valor AND empresa_id = :empresa";
    }else if($buscar == 'cpf'){
        $sql = "SELECT * FROM usuarios WHERE cpf = :valor AND empresa_id = :empresa";
    }else if($buscar == 'nome'){
        $sql = "SELECT * FROM usuarios WHERE nome like concat('%', :valor, '%') AND empresa_id = :empresa";
    }else if($buscar == 'nivel'){
        $sql = "SELECT * FROM usuarios WHERE nivel_acesso_id = ? AND empresa_id = :empresa";
    }

    $sql = $pdo->prepare($sql);

    $sql->bindValue('valor', $valor);
    $sql->bindValue('empresa', $empresa);

    $sql->execute();

    if($sql->rowCount() > 0){
        $resultado = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    }else{
        return false;
    }
  }

  public function delete($id) {
    $sql = 'DELETE FROM usuarios WHERE id = ?';

   
  }
}
