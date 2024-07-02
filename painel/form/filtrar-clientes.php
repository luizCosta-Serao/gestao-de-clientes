<?php
  include('../../config.php');
  if (Painel::isLogin() === false) {
    die('Você não está logado!');
  }
  header('Content-Type: application/json');
  $busca = $_GET['busca'];
  $sql = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE nome LIKE '%$busca%' OR email LIKE '%$busca%' OR cpf_cnpj LIKE '%$busca%'");
  $sql->execute();
  if ($sql->rowCount() >= 1) {
    echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
  } else {
    echo 'false';
    echo json_encode('Ocorreu um erro ao exibir os clientes');
  }
 
  ?>