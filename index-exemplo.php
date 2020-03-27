<?php

require_once 'vendor/autoload.php';

$produto = new \App\Model\Produto();

$produto->setId('4');
$produto->setNome('Notebook ACER');
$produto->setDescricao('i5 4gb');

$produtoDao = new \App\Model\ProdutoDao();
//Criar
//$produtoDao->create($produto);

//ler
//$produtoDao->read();
//foreach($produtoDao->read() as $produto):
  //echo $produto['nome']."<br>".$produto['descricao']."<br>";
//endforeach;

//Alterar
//$produtoDao->update($produto);

//Excluir
$produtoDao->delete($produto);
