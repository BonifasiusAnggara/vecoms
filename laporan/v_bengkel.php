<?php
	include ("../config/koneksi.php");
	ob_start();
	include "bengkel.php";
	$content = ob_get_clean();
	$datetime = date('Y-m-d');

	//Conversion HTML=>PDF
	require_once "../pdf/html2pdf.class.php";
	try {
		$html2pdf = new HTML2PDF('P','A4','en',FALSE,'ISO-8859-15');
		$html2pdf->writeHtml($content, isset($_GET['vuehtm']));
		$html2pdf->Output('"Bengkel-Vecoms.pdf');
	} catch(HTML2PDF_exception $e) {echo $e;}
?>