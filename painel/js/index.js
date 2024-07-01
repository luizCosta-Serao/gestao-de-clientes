$('#cadastro-cliente').submit(function(e) {
  e.preventDefault();
  let name = $('#name').val();
  let email = $('#email').val();
  let type = $('#type').val();
  let cpf_cnpj = $('#cpf-cnpj').val();

  $.ajax({
    url: 'http://localhost/gestao-clientes/painel/form/cadastro-cliente.php',
    method: 'POST',
    data: {
      name,
      email,
      type,
      cpf_cnpj,
    },
    dataType: 'json'
  }).done(function(data) {
    $('#name').val('');
    $('#email').val('');
    $('#type').val('');
    $('#cpf-cnpj').val('');
    console.log(data);
  });
})

function getClients() {
  $.ajax({
    url: 'http://localhost/gestao-clientes/painel/form/exibir-clientes.php',
    method: 'GET',
    contentType: "application/json; charset=utf-8",
    dataType: 'json',
  }).done(function(data) {
    if (typeof data === 'string') {
      return $('.box-client').prepend(`
        <p class="erro">Não existem clientes cadastrados</p>
      `);
    }
      for (let i = 0; i < data.length; i++) {
        $('.box-client').prepend(`
          <div class="box-single-client">
            <h2>Nome: ${data[i].nome}</h2>
            <p>Email: ${data[i].email}</p>
            <p>Tipo: ${data[i].tipo}</p>
            <p>CPF/CNPJ: ${data[i].cpf_cnpj}</p>
            <a class="btn-delete" href="${location.href}?id=${data[i].id}">Deletar</a>
          </div>
        `)
      }
  });
}

if(location.href.includes('listar-clientes')) {
  getClients();
  const id = location.search.split('=')[1]
  if (id) {
    $.ajax({
      url: 'http://localhost/gestao-clientes/painel/form/deletar-cliente.php',
      method: 'GET',
      data: {
        id
      }
    })
    location.href = 'http://localhost/gestao-clientes/painel/listar-clientes'
  }
}