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
      if (strtotime($dateVencimento) < time()) {
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