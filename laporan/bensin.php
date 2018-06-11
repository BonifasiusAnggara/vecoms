<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$tgl5 = $_GET['tgl7'];
	$tgl6 = $_GET['tgl8'];
	$datetime1 = $tgl5." 00:00:00";
	$datetime2 = $tgl6." 23:59:59";
	$plat_no = $_GET['plat_no'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Bensin Mobil</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ BENSIN MOBIL ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<h6>
		<?php
			if ($tgl5 == '' AND $tgl6 == '') {

			} else {
				echo "Periode"."&nbsp;".": ".tgl_indo($tgl5)." s/d ".tgl_indo($tgl6);
			}
		?>
		</h6>
		<h6>
		<?php
			if ($plat_no == '') {

			} else {
				echo "Plat No"."&nbsp;&nbsp;".": ".$plat_no;
			}
		?>
		</h6>
		<?php
		if ($tgl5 == '' AND $tgl6 == '' AND $plat_no == '') { 			
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="80">Date Time</td>
				<td width="50">Plat No</td>		
				<td width="80">Owner Mobil</td>
				<td width="70">Litter Bensin</td>
				<td width="80">Km Bensin</td>
				<td width="80">Rasio Bensin</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg ORDER BY id_bensin DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['datetime'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo $r['bensin']?></td>
				<td><?php echo $r['km_bensin']?></td>
				<td><?php echo $r['rasio']?></td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="6">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<?php }
		
		else if ($tgl5 == '' AND $tgl6 == '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="80">Date Time</td>
				<td width="50">Plat No</td>		
				<td width="80">Owner Mobil</td>
				<td width="70">Litter Bensin</td>
				<td width="80">Km Bensin</td>
				<td width="80">Rasio Bensin</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg AND plat_no='$plat_no' ORDER BY id_bensin DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['datetime'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo $r['bensin']?></td>
				<td><?php echo $r['km_bensin']?></td>
				<td><?php echo $r['rasio']?></td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="6">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<?php } 
		elseif ($tgl5 != '' AND $tgl6 != '' AND $plat_no == '') {
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="80">Date Time</td>
				<td width="50">Plat No</td>		
				<td width="80">Owner Mobil</td>
				<td width="70">Litter Bensin</td>
				<td width="80">Km Bensin</td>
				<td width="80">Rasio Bensin</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg AND bensin.datetime BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY id_bensin DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['datetime'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo $r['bensin']?></td>
				<td><?php echo $r['km_bensin']?></td>
				<td><?php echo $r['rasio']?></td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="6">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<?php }
		elseif ($tgl5 != '' AND $tgl6 != '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="80">Date Time</td>
				<td width="50">Plat No</td>		
				<td width="80">Owner Mobil</td>
				<td width="70">Litter Bensin</td>
				<td width="80">Km Bensin</td>
				<td width="80">Rasio Bensin</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg AND plat_no='$plat_no' AND bensin.datetime BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY id_bensin DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['datetime'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo $r['bensin']?></td>
				<td><?php echo $r['km_bensin']?></td>
				<td><?php echo $r['rasio']?></td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="6">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<?php }
		?>
	</div>
</body>
</html>