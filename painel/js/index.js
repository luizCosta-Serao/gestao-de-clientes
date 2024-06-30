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
      cpf_cnpj
    },
    dataType: 'json'
  }).done(function(result) {
    $('#name').val('');
    $('#email').val('');
    $('#type').val('');
    $('#cpf-cnpj').val('');
    console.log(result);
  });
})