<?php
  // Packagist = Site com bibliotecas PHP via composer
  ob_start();
  include('template-pdf.php');
  $conteudo = ob_get_contents();
  ob_end_clean();
  
  use Dompdf\Dompdf;
  include('vendor/autoload.php');
  
  // instantiate and use the dompdf class
  $dompdf = new Dompdf(['enabled_remote' => false]);
  $dompdf->loadHtml($conteudo);

  // (Optional) Setup the paper size and orientation
  $dompdf->setPaper('A4', 'landscape');

  // Render the HTML as PDF
  $dompdf->render();

  // Output the generated PDF to Browser
  $dompdf->stream();
  
?>