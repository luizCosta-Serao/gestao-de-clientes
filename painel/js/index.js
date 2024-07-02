// Cadastro de cliente
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

// função para exibir todos os clientes
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
            <a class="btn-editar" href="${location.href.replace('listar-clientes', 'editar-cliente')}?id=${data[i].id}">Editar</a>
          </div>
        `)
      }
  });
}

// Se estiver na página listar-clientes
if(location.href.includes('listar-clientes')) {
  let busca = $('#busca').val()
  // Mostrar todos os clientes
  if (busca === '') {
    getClients();
  } else {
   
  }
  const id = location.search.split('=')[1]

  
   // Filtrar clientes
   $('.busca-clientes form').submit(function(e) {
    e.preventDefault()
    const busca = $('#busca').val();

    $.ajax({
      url: 'http://localhost/gestao-clientes/painel/form/filtrar-clientes.php',
      method: 'GET',
      data: {
        busca,
      },
      contentType: "application/json; charset=utf-8",
      dataType: 'json',
    }).done(function(data) {
      console.log(data)
      if (typeof data === 'string') {
        return $('.box-client').prepend(`
          <p class="erro">Não existem clientes cadastrados com os valores passados</p>
        `);
      }
      $('.box-client').empty();
        for (let i = 0; i < data.length; i++) {
          $('.box-client').prepend(`
            <div class="box-single-client">
              <h2>Nome: ${data[i].nome}</h2>
              <p>Email: ${data[i].email}</p>
              <p>Tipo: ${data[i].tipo}</p>
              <p>CPF/CNPJ: ${data[i].cpf_cnpj}</p>
              <a class="btn-delete" href="${location.href}?id=${data[i].id}">Deletar</a>
              <a class="btn-editar" href="${location.href.replace('listar-clientes', 'editar-cliente')}?id=${data[i].id}">Editar</a>
            </div>
          `)
        }
    });
  }) 

  // Deletar cliente
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

// Se estiver na página editar-cliente
if (location.href.includes('editar-cliente')) {
  const id = location.search.split('=')[1]
  // puxar valores do cliente que será editado através do id
  $.ajax({
    url: 'http://localhost/gestao-clientes/painel/form/atualizar-cliente.php',
    method: 'GET',
    data: {
      id,
    },
    dataType: 'json',
  }).done(function(data) {
    $('#name').val(data.nome);
    $('#email').val(data.email);
    $('#type').val(data.tipo);
    $('#cpf-cnpj').val(data.cpf_cnpj);
    console.log(data);
  });

  // Atualizar dados do cliente
  $('#editar-cliente').submit(function(e) {
    e.preventDefault();
    let name = $('#name').val();
    let email = $('#email').val();
    let type = $('#type').val();
    let cpf_cnpj = $('#cpf-cnpj').val();
  
    $.ajax({
      url: 'http://localhost/gestao-clientes/painel/form/atualizar-cliente.php',
      method: 'POST',
      data: {
        name,
        email,
        type,
        cpf_cnpj,
        id,
      },
      dataType: 'json'
    }).done(function(data) {
      $('#name').val(data.nome);
      $('#email').val(data.email);
      $('#type').val(data.tipo);
      $('#cpf-cnpj').val(data.cpf_cnpj);
      console.log(data);
    });
  })

}