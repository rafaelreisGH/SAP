<?php 

//AUTOLOAD DO COMPOSER
require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper('A4');

//RENDERIZAR O ARQUIVO PDF
$dompdf->render();

$dompdf->stream('file.pdf', ['Attachment' => false]);

/* //AUTOLOAD DO COMPOSER
require '../vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
require __DIR__.'/view_fad.php';
$dompdf->loadHtml(ob_get_clean());

$dompdf->setPaper('A4');

//RENDERIZAR O ARQUIVO PDF
$dompdf->render();

$dompdf->stream('file.pdf', ['Attachment' => false]); */

?>