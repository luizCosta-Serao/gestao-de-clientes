<?php
  include('../../config.php');
  if (Painel::isLogin() === false) {
    die('Você não está logado!');
  }
  header('Content-Type: application/json');
  $nome = $_POST['name'];
  $email = $_POST['email'];
  $tipo = $_POST['type'];
  $cpf_cnpj = $_POST['cpf_cnpj'];
  $sql = MySql::connect()->prepare("INSERT INTO `clientes` VALUES (null, ?, ?, ?, ?)");
  $sql->execute(array($nome, $email, $tipo, $cpf_cnpj));
  if ($sql->rowCount() >= 1) {
    return json_encode('Cliente cadastrado com sucesso');
  } else {
    return json_encode('Ocorreu um erro');
  }
 
  ?>