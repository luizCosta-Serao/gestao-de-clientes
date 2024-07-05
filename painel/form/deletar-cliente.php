<?php
  include('../../config.php');
  if (Painel::isLogin() === false) {
    die('Você não está logado!');
  }
  header('Content-Type: application/json');
  $id = $_GET['id'];
  echo $id;
  $sql = MySql::connect()->prepare("DELETE FROM `clientes` WHERE id = ?");
  MySql::conecct()->prepare("DELETE FROM `financeiro` WHERE cliente_id = $id");
  $sql->execute(array($id));
  if ($sql->rowCount() >= 1) {
    echo json_encode($id);
  } else {
    echo json_encode('Ocorreu um erro');
  }
  
  ?>