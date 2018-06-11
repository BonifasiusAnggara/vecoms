<?php
	include ("../config/koneksi.php");
	$kode_perp_stnk = $_GET['kode_perp_stnk'];
	$query = mysqli_query($conn, "SELECT * FROM perp_stnk WHERE kode_perp_stnk='$kode_perp_stnk'");
	$row = mysqli_fetch_array($query);
	ob_start();
	include "perp_stnk.php";
	$content = ob_get_clean();
	$datetime = date('Y-m-d');

	//Conversion HTML=>PDF
	require_once "../pdf/html2pdf.class.php";
	try {
		$html2pdf = new HTML2PDF('P','A4','en',FALSE,'ISO-8859-15');
		$html2pdf->writeHtml($content, isset($_GET['vuehtm']));
		$html2pdf->Output('""'.$kode_perp_stnk.'"-Vecoms.pdf');
	} catch(HTML2PDF_exception $e) {echo $e;}
?>