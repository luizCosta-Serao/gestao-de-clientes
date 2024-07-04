<?php include('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  
    h1 {
      background: #333;
      color: #fff;
      padding: 8px;
      text-align: center;
    }
  
    section {
      width: 900px;
      margin: 0 auto;
    }
  
    table {
      width:900px;
      margin-top: 20px;
      border-collapse: collapse;
    }
  
    table thead th {
      padding: 0 0 10px 0;
    }
  
    table td {
      border: 1px solid #ccc;
      padding: 8px;
      font-size: 14px;
    }
  </style>
  
  <?php
    $nome = isset($_GET['pagamento']) && $_GET['pagamento'] === 'concluidos' ? 'Concluidos' : 'Pendentes';
  ?>
  <section>
      <h1>Pagamentos <?php echo $nome; ?></h1>
      <table>
        <thead>
          <th>Nome do pagamento</th>
          <th>Cliente</th>
          <th>Valor</th>
          <th>Vencimento</th>
        </thead>
        <tbody>
          <?php
          if ($nome === 'Pendentes') {
            $nome = 0;
          } else {
            $nome = 1;
          }
            // exibir os pagamentos concluidos
            $pagamentos = MySql::connect()->prepare("SELECT * FROM `financeiro` WHERE status = ? ORDER BY vencimento ASC");
            $pagamentos->execute(array($nome));
            $pagamentos = $pagamentos->fetchAll();
            foreach ($pagamentos as $key => $value) {
          ?>
            <tr>
              <td><?php echo $value['nome'] ?></td>
              <?php
                $cliente = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
                $cliente->execute(array($value['cliente_id']));
                $cliente = $cliente->fetch();
              ?>
              <td><?php echo $cliente['nome'] ?></td>
              <td><?php echo $value['valor'] ?></td>
              <td><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
  </section>
</body>
</html>