<?php
	include ("../config/koneksi.php");
	$kode_svc = $_GET['kode_svc'];
	$query = mysqli_query($conn, "SELECT * FROM service WHERE kode_svc='$kode_svc'");
	$row = mysqli_fetch_array($query);
	ob_start();
	include "service.php";
	$content = ob_get_clean();
	$datetime = date('Y-m-d');

	//Conversion HTML=>PDF
	require_once "../pdf/html2pdf.class.php";
	try {
		$html2pdf = new HTML2PDF('P','A4','en',FALSE,'ISO-8859-15');
		$html2pdf->writeHtml($content, isset($_GET['vuehtm']));
		$html2pdf->Output('""'.$kode_svc.'"-Vecoms.pdf');
	} catch(HTML2PDF_exception $e) {echo $e;}
?>