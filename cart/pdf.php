<?php
require_once('./dompdf/autoload.inc.php');

use Dompdf\Dompdf;
$dompdf = new Dompdf();


$username = "Irfan Shah ";

$html = '<h1 style="color:red;">Hello ' . $username . '</h1>';


    
      








//////////////////////////////////////////
//file_get_contents('cart.html');
$dompdf->loadHtml($html);

$dompdf->setPaper('A4','landscape');

$dompdf->render();
$dompdf->stream();


?>
