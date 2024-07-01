<?php
  include('../../config.php');
  if (Painel::isLogin() === false) {
    die('Você não está logado!');
  }
  header('Content-Type: application/json');
  if ($_GET) {
    $id = $_GET['id'];
    $sql = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
    $sql->execute(array($id));
    if ($sql->rowCount() >= 1) {
      echo json_encode($sql->fetch());
    } else {
      echo json_encode('Ocorreu um erro');
    }
  }

  if ($_POST) {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $tipo = $_POST['type'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $id = $_POST['id'];
    
    $sql = MySql::connect()->prepare("UPDATE `clientes` SET nome = ?, email = ?, tipo = ?, cpf_cnpj = ? WHERE id = ?");
    $sql->execute(array($nome, $email, $tipo, $cpf_cnpj, $id));

    $clienteAtualizado = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
    $clienteAtualizado->execute(array($id));
    if ($clienteAtualizado->rowCount() >= 1) {
      echo json_encode($clienteAtualizado->fetch());
    } else {
      echo json_encode('Ocorreu um erro');
    }
  }
  ?>