<?php
	include ("../config/koneksi.php");
	$kode_spr = $_GET['kode_spr'];
	$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart WHERE kode_spr='$kode_spr'");
	$row = mysqli_fetch_array($query);
	ob_start();
	include "sparepart.php";
	$content = ob_get_clean();
	$datetime = date('Y-m-d');

	//Conversion HTML=>PDF
	require_once "../pdf/html2pdf.class.php";
	try {
		$html2pdf = new HTML2PDF('P','A4','en',FALSE,'ISO-8859-15');
		$html2pdf->writeHtml($content, isset($_GET['vuehtm']));
		$html2pdf->Output('""'.$kode_spr.'"-Vecoms.pdf');
	} catch(HTML2PDF_exception $e) {echo $e;}
?>