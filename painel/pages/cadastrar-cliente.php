<form id="cadastro-cliente" method="post">
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