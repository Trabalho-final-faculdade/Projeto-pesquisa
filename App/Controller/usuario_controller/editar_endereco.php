<?php 

session_start();

if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['cep']) && !empty($_POST['cep'])
&& isset($_POST['rua']) && !empty($_POST['rua']) && isset($_POST['numero']) && !empty($_POST['numero'])
&& isset($_POST['bairro']) && !empty($_POST['bairro']) && isset($_POST['cidade'])
&& !empty($_POST['cidade']) && isset($_POST['estado']) && !empty($_POST['estado'])
&& isset($_POST['pais']) && !empty($_POST['pais'])){

    require '../../Model/Conexao.php';
    require '../../Model/EnderecoDao.php';
    require '../../Model/Endereco.php';

    $ed = new \App\Model\EnderecoDao();
    $e = new \App\Model\Endereco();

    $e->setCep(addslashes($_POST['cep']));
    $e->setRua(addslashes($_POST['rua']));
    $e->setNumero(addslashes($_POST['numero']));
    $e->setBairro(addslashes($_POST['bairro']));
    $e->setComplemento(addslashes($_POST['complemento']));
    $e->setCidade($_POST['cidade']);
    $e->setEstado(addslashes($_POST['estado']));
    $e->setPais($_POST['pais']);

    if($ed->update($e, $_POST['endereco_id'])){
        $_SESSION['edicao_endereco'] = true;
    }else{
        $_SESSION['edicao_endereco'] = false;
    }
    header("Location: ../../View/usuario/editar-endereco.php?id=".$_POST['id']); 
}


?>