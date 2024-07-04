<?php
  // Obtendo o ID através do parâmetro id da URL
  $id = $_GET['id'];
?>
<form id="editar-cliente" method="post">
  <label for="name">Nome</label>
  <input type="text" name="name" id="name">

  <label for="email">Email</label>
  <input type="email" name="email" id="email">

  <label for="type">Tipo</label>
  <select name="type" id="type">
    <option value="fisico">Físico</option>
    <option value="juridico">Jurídico</option>
  </select>

  <label for="cpf-cnpj">CPF/CNPJ</label>
  <input type="text" name="cpf-cnpj" id="cpf-cnpj">

  <input type="submit" name="action" value="Cadastrar">
</form>

<h1 class="title">Adicionar pagamento</h1>
<form id="adicionar-pagamento" action="" method="post">
  <?php
    if (isset($_POST['btn_add_pagamento'])) {
      // Salvando valores em variáveis
      $cliente_id = $id;
      $nome = $_POST['nome_pagamento'];
      $valor = str_replace('.', '', $_POST['valor_pagamento']);
      $valor = str_replace(',', '.', $valor);
      $vencimento = $_POST['vencimento'];
      $status = 0;
      $numero_parcelas = $_POST['numero_parcelas'];
      // Formatando data para verificar se data é negativa
      $dateVencimento = explode('/', $vencimento);
      $dateVencimento = $dateVencimento[2].'-'.$dateVencimento[1].'-'.$dateVencimento[0];
      if (strtotime($dateVencimento) < strtotime(date('Y-m-d'))) {
        // se data for negativa, exibir mensagem de erro
        echo '<p class="erro">Você selecionou uma data negativa</p>';
      } else {
        // salvando no banco de dados os pagamentos
        for ($i=0; $i < $numero_parcelas ; $i++) {
          // formatando data para usar o strtotime para adicionar as parcelas de pagamento
          $date = explode('/', $vencimento);
          $date = $date[2].'-'.$date[1].'-'.$date[0];
          $date =  strtotime($date) + (60 * 60 * 24 * 31 * $i);
  
          // inserindo no banco de dados
          $sql = MySql::connect()->prepare("INSERT INTO `financeiro` VALUES (null, ?, ?, ?, ?, ?)");
          $sql->execute(array($cliente_id, $nome, $valor, date('Y-m-d',$date), $status));
        }
        // Mensagem de sucesso
        echo '<p class="sucesso">Pagamento inserido com sucesso</p>';
      }
    }

    if (isset($_GET['pago'])) {
      $sql = MySql::connect()->prepare("UPDATE `financeiro` SET status = 1 WHERE id = ?");
      $sql->execute(array($_GET['pago']));
      echo '<p class="sucesso">O pagamento foi quitado com sucesso</p>';
    }
  ?>

  <label for="nome_pagamento">Nome do Pagamento</label>
  <input type="text" name="nome_pagamento" id ="nome_pagamento">

  <label for="valor_pagamento">Valor do Pagamento</label>
  <input type="text" name="valor_pagamento" id ="valor_pagamento">

  <label for="numero_parcelas">Número de Parcelas</label>
  <input type="text" name="numero_parcelas" id="numero_parcelas">

  <label for="vencimento">Vencimento</label>
  <input type="text" name="vencimento" id="vencimento">

  <input type="submit" name="btn_add_pagamento" id="btn_add_pagamento" value="Adicionar Pagamento">
</form>

<section class="pagamentos-pendentes">
    <h1 class="title">Pagamentos pendentes</h1>
    <div class="lista-pagamentos-pendentes">
      <div class="titulos-tabela">
        <p>Nome do pagamento</p>
        <p>Cliente</p>
        <p>Valor</p>
        <p>Vencimento</p>
        <p>Enviar Email</p>
        <p>Marcar como Pago</p>
      </div>
      <div class="valores-tabela">
        <?php
          $pagamentosPendentes = MySql::connect()->prepare("SELECT * FROM `financeiro` WHERE status = ? AND cliente_id = ? ORDER BY vencimento ASC");
          $pagamentosPendentes->execute(array(0, $id));
          $pagamentosPendentes = $pagamentosPendentes->fetchAll();
          foreach ($pagamentosPendentes as $key => $value) {
        ?>
          <p><?php echo $value['nome'] ?></p>
          <?php
            $cliente = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
            $cliente->execute(array($value['cliente_id']));
            $cliente = $cliente->fetch();
            
            $style = '';
            if (strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])) {
              $style = 'style="background-color: red"';
            }
          ?>
          <p><?php echo $cliente['nome'] ?></p>
          <p><?php echo $value['valor'] ?></p>
          <p <?php echo $style; ?>><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></p>
          <a href="">Enviar Email</a>
          <a class="pagamento-realizado" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-cliente?id=<?php echo $id ?>&pago=<?php echo $value['id']; ?>">Pago</a>
        <?php } ?>
      </div>
    </div>
</section>