<?php 
require_once('dompdf/autoload.php');

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$html="<!DOCTYPE html>
<html>
<head>
	<style>
		input{display:inline-block;}
	</style>
</head>
<body>
";

$html.=$this->fetch('content');
$html.="
</body>
</html>
";

echo $html;exit;

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser

// $output = $dompdf->output();
// file_put_contents("/path/to/file.pdf", $output);

$dompdf->stream($name);
exit;
?>