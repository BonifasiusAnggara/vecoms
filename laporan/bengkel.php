<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Bengkel</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ DATA BENGKEL ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>		
		<hr style="border: solid 3px #0B8D45;">
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="60">Kode Bengkel</td>
				<td width="60">Nama Bengkel</td>
				<td width="160">Alamat</td>
				<td width="50">No Telephone</td>
				<td width="60">Contact Person</td>
				<td width="90">Nomor Kontrak</td>
				<td width="80">Tgl. Berlaku Kontrak</td>
			</tr>
			<?php
				$query = mysqli_query($conn, "SELECT * FROM bengkel");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) {
			?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['kode_bkl'];?></td>
				<td><?php echo $r['nama_bkl'];?></td>
				<td><?php echo $r['alamat'];?></td>
				<td><?php echo $r['no_telp'];?></td>
				<td><?php echo $r['contact_person'];?></td>
				<td><?php echo $r['no_kontrak'] ?></td>
				<td><?php echo $r['tgl_berlaku_kontrak'] ?></td>
			</tr>
			<?php $no++; } ?>
			<tr>
				<td colspan="7">
				<?php $jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bengkel")); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
	</div>
</body>
</html>