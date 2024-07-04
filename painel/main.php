<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- plugin calendário -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/default/zebra_datepicker.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL; ?>/css/style.css">
  <title>Painel de Controle</title>
</head>
<body>
  <header class="header">
    <?php
      if (isset($_GET['loggout'])) {
        session_destroy();
        header('Location: '.INCLUDE_PATH_PAINEL);
      }
    ?>
    <p>Seja bem vindo <?php echo $_SESSION['user'] ?></p>
    <a href="<?php echo INCLUDE_PATH_PAINEL; ?>?loggout">
      Sair
    </a>
  </header>
  <section class="container">
    <aside class="sidebar">
        <a href="<?php echo INCLUDE_PATH_PAINEL; ?>">Início</a>
        <h2>Gestao de Clientes</h2>
        <a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-cliente">Cadastrar Cliente</a>
        <a href="<?php echo INCLUDE_PATH_PAINEL; ?>listar-clientes">Listar Clientes</a>
        <a href="<?php echo INCLUDE_PATH_PAINEL; ?>visualizar-pagamentos">Visualizar Pagamentos</a>
    </aside>
    <div class="content">
      <?php
        $url = isset($_GET['url']) ? $_GET['url'] : 'home';
        if (file_exists('pages/'.$url.'.php')) {
          include('pages/'.$url.'.php');
        } else {
          include('pages/home.php');
        }
      ?>
    </div>
  </section>
  <script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.js"></script>
  <!-- plugin calendário -->
  <script src="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/zebra_datepicker.min.js"></script>
  <!-- plugin maskMoney -->
  <script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/plugins/jquery.maskMoney.js"></script>
  <!-- Plugin mask -->
  <script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/plugins/jquery.mask.js"></script>
  <script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/index.js"></script>
  <script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/financeiro.js"></script>
</body>
</html>