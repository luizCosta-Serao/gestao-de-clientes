<?php
  include('../../config.php');
  if (Painel::isLogin() === false) {
    die('Você não está logado!');
  }
  header('Content-Type: application/json');
  $sql = MySql::connect()->prepare("SELECT * FROM `clientes`");
  $sql->execute();
  if ($sql->rowCount() >= 1) {
    echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
  } else {
    echo json_encode('Ocorreu um erro ao exibir os clientes');
  }
 
  ?>