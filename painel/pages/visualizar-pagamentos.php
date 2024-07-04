<?php
   // Definir pagamento como pago/concluído
   if (isset($_GET['pago'])) {
    $sql = MySql::connect()->prepare("UPDATE `financeiro` SET status = 1 WHERE id = ?");
    $sql->execute(array($_GET['pago']));
    echo '<p class="sucesso">O pagamento foi quitado com sucesso</p>';
  }
?>
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
          // exibir os pagamentos pendentes
          $pagamentosPendentes = MySql::connect()->prepare("SELECT * FROM `financeiro` WHERE status = ? ORDER BY vencimento ASC");
          $pagamentosPendentes->execute(array(0));
          $pagamentosPendentes = $pagamentosPendentes->fetchAll();
          foreach ($pagamentosPendentes as $key => $value) {
        ?>
          <p><?php echo $value['nome'] ?></p>
          <?php
            $cliente = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
            $cliente->execute(array($value['cliente_id']));
            $cliente = $cliente->fetch();
            
            $style = '';
            // Se pagamento pendente já tiver vencido mudar estilo para indicar que está vencido
            if (strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])) {
              $style = 'style="background-color: red"';
            }
          ?>
          <p><?php echo $cliente['nome'] ?></p>
          <p><?php echo $value['valor'] ?></p>
          <p <?php echo $style; ?>><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></p>
          <a href="">Enviar Email</a>
          <!-- âncora com parâmetros no href para definir como pago -->
          <a class="pagamento-realizado" href="<?php echo INCLUDE_PATH_PAINEL; ?>visualizar-pagamentos?pago=<?php echo $value['id']; ?>">Pago</a>
        <?php } ?>
      </div>
    </div>
</section>


<section class="pagamentos-concluidos">
    <h1 class="title">Pagamentos Concluídos</h1>
    <div class="lista-pagamentos-concluidos">
      <div class="titulos-tabela">
        <p>Nome do pagamento</p>
        <p>Cliente</p>
        <p>Valor</p>
        <p>Vencimento</p>
      </div>
      <div class="valores-tabela">
        <?php
          // exibir os pagamentos concluidos
          $pagamentosConcluidos = MySql::connect()->prepare("SELECT * FROM `financeiro` WHERE status = ? ORDER BY vencimento ASC");
          $pagamentosConcluidos->execute(array(1));
          $pagamentosConcluidos = $pagamentosConcluidos->fetchAll();
          foreach ($pagamentosConcluidos as $key => $value) {
        ?>
          <p><?php echo $value['nome'] ?></p>
          <?php
            $cliente = MySql::connect()->prepare("SELECT * FROM `clientes` WHERE id = ?");
            $cliente->execute(array($value['cliente_id']));
            $cliente = $cliente->fetch();
          ?>
          <p><?php echo $cliente['nome'] ?></p>
          <p><?php echo $value['valor'] ?></p>
          <p><?php echo date('d/m/Y',strtotime($value['vencimento'])) ?></p>
        <?php } ?>
      </div>
    </div>
</section>