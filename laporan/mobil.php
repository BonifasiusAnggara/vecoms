<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Mobil</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ DATA MOBIL ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<table class="table">			
			<tr>
				<td width="10">No.</td>
				<td width="50">Plat No</td>
				<td width="80">Type</td>
				<td width="90">Nama Pemilik</td>
				<td width="80">Jabatan</td>
				<td width="80">Direktorat</td>					
				<td width="80">Masa Berlaku STNK</td>
				<td width="80">Masa Berlaku KEUR</td>
			</tr>
			<?php
				$query = mysqli_query($conn, "SELECT * FROM mobil, direktorat, pegawai WHERE mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) {
			?>
				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['plat_no'];?></td>
					<td><?php echo $r['type'];?></td>
					<td><?php echo $r['nama_peg'];?></td>
					<td><?php echo $r['jabatan'];?></td>
					<td><?php echo $r['deskripsi'];?></td>
					<?php if ($r['ms_ber_stnk'] == 0000-00-00) { ?>
					<td></td>
					<?php } else { ?>
					<td align="right"><?php echo tgl_indo($r['ms_ber_stnk']);?></td>
					<?php } ?>
					<?php if ($r['ms_ber_keur'] == 0000-00-00) { ?>
					<td></td>
					<?php } else { ?>
					<td align="right"><?php echo tgl_indo($r['ms_ber_keur']);?></td>
					<?php } ?>
				</tr>
			<?php $no++; } ?>
				<tr>
					<td colspan="7">
					<?php $jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mobil")); echo "Jumlah Record"; ?>
					</td>
					<td align="right"><?php echo $jmldata;?></td>
				</tr>
		</table>
	</div>
</body>
</html>