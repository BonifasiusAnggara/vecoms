<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Kategori Service</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ KATEGORI SERVICE ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="150" colspan="2">Nama Bengkel</td>
			</tr>
			
			<?php
				$query = mysqli_query($conn, "SELECT * FROM bengkel");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) {
			?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td>
					<?php echo $r['nama_bkl']; ?>
					<table style="border: none; margin: 0px;">
						<tr>
							<td width="250">Nama Service</td>
							<td width="100">Harga</td>
						</tr>					
						<?php
							$id_bkl = $r['id_bkl'];
							$srv = mysqli_query($conn, "SELECT * FROM kat_service, bengkel WHERE kat_service.id_bkl=bengkel.id_bkl AND kat_service.id_bkl='$id_bkl'");
							while ($sv = mysqli_fetch_array($srv)) { ?>
						<tr>
							<td><?php echo $sv['nama_serv']?></td>
							<td align="right"><?php echo format_rupiah($sv['harga_serv']); ?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
			<?php $no++; } ?>
		</table>
	</div>
</body>
</html>
