// Plugin Mask
$('#vencimento').mask('00/00/0000')
$('#numero_parcelas').mask('00')
$('#intervalo').mask('00')

// Plugin maskMoney
$('#valor_pagamento').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

// Plugin calendário para o input vencimento
$('#vencimento').Zebra_DatePicker({
  format: 'd/m/Y',
  readonly_element: false,
});