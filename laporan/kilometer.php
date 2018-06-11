<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$tgl5 = $_GET['tgl5'];
	$tgl6 = $_GET['tgl6'];
	$datetime1 = $tgl5." 00:00:00";
	$datetime2 = $tgl6." 23:59:59";
	$plat_no = $_GET['plat_no'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Kilometer Truck</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ KILOMETER TRUCK ~ </h2>
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
				<td width="40">Plat No</td>		
				<td width="80">Driver</td>		
				<td width="40">Km. Berangkat</td>
				<td width="60">Jam Berangkat</td>
				<td width="40">Km. Pulang</td>					
				<td width="60">Jam Pulang</td>
				<td width="30">Jarak Tempuh</td>
				<td width="40">Litter Solar</td>
				<td width="40">Km Solar</td>
				<td width="40">Rasio Solar</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg ORDER BY id_km DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo format_ribuan($r['km_brkt']);?></td>
				<td><?php echo tgl_indo2($r['jam_brkt']);?></td>
				<td><?php echo format_ribuan($r['km_plg']);?></td>
				<td><?php echo tgl_indo2($r['jam_plg']);?></td>
				<td><?php echo format_ribuan($r['jarak_tempuh']);?></td>
				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['solar_1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['solar_2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['solar_3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['km_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['km_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['km_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['rasio_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['rasio_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['rasio_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="10">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<table class="ttd">
			<?php
				$query = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS jarak_tempuh, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3 FROM kilometer");
				$row = mysqli_fetch_array($query);
				$jartemp = $row['jarak_tempuh'];
				$solar = $row['solar_1'] + $row['solar_2'] + $row['solar_3'];
				$rasio = $jartemp/$solar;
				
				$query1 = mysqli_query($conn, "SELECT AVG(rasio_solar1) AS rasio1 FROM kilometer WHERE rasio_solar1 <> 0");
				$raw1 = mysqli_fetch_array($query1);

				$query2 = mysqli_query($conn, "SELECT AVG(rasio_solar2) AS rasio2 FROM kilometer WHERE rasio_solar2 <> 0");
				$raw2 = mysqli_fetch_array($query2);

				$query3 = mysqli_query($conn, "SELECT AVG(rasio_solar3) AS rasio3 FROM kilometer WHERE rasio_solar3 <> 0");
				$raw3 = mysqli_fetch_array($query3);

				if (($raw3['rasio3'] != 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2']+$raw3['rasio3'])/3;
				} elseif(($raw3['rasio3'] == 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2'])/2;
				} elseif (($raw3['rasio3'] == 0) && ($raw2['rasio2'] == 0)) {
					$avg = $raw1['rasio1'];
				}
			?>
			<tr>
				<td>
					Total Jarak Tempuh : <?php echo format_ribuan2($jartemp)." Km"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Total Pemakaian Solar : <?php echo format_ribuan2($solar)." Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rasio Solar : <?php echo format_ribuan2($rasio)." Km/Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rata-rata rasio yang dicatat di system : <?php echo format_ribuan2($avg)." Km/Litter"; ?>
				</td>
			</tr>
		</table>
		<?php }
		
		else if ($tgl5 == '' AND $tgl6 == '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="40">Plat No</td>		
				<td width="80">Driver</td>		
				<td width="40">Km. Berangkat</td>
				<td width="60">Jam Berangkat</td>
				<td width="40">Km. Pulang</td>					
				<td width="60">Jam Pulang</td>
				<td width="30">Jarak Tempuh</td>
				<td width="40">Litter Solar</td>
				<td width="40">Km Solar</td>
				<td width="40">Rasio Solar</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND plat_no='$plat_no' ORDER BY id_km DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo format_ribuan($r['km_brkt']);?></td>
				<td><?php echo tgl_indo2($r['jam_brkt']);?></td>
				<td><?php echo format_ribuan($r['km_plg']);?></td>
				<td><?php echo tgl_indo2($r['jam_plg']);?></td>
				<td><?php echo format_ribuan($r['jarak_tempuh']);?></td>
				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['solar_1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['solar_2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['solar_3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['km_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['km_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['km_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['rasio_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['rasio_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['rasio_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="10">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<table class="ttd">
			<?php
				$pre_query = mysqli_query($conn, "SELECT id_mobil AS id_mobil FROM mobil WHERE plat_no = '$plat_no'");
				$pre_row = mysqli_fetch_array($pre_query);
				$id_mobil = $pre_row['id_mobil'];
				
				$query = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS jarak_tempuh, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3 FROM kilometer WHERE id_mobil='$id_mobil'");
				$row = mysqli_fetch_array($query);
				$jartemp = $row['jarak_tempuh'];
				$solar = $row['solar_1'] + $row['solar_2'] + $row['solar_3'];
				$rasio = $jartemp/$solar;
				
				$query1 = mysqli_query($conn, "SELECT AVG(rasio_solar1) AS rasio1 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar1 <> 0");
				$raw1 = mysqli_fetch_array($query1);

				$query2 = mysqli_query($conn, "SELECT AVG(rasio_solar2) AS rasio2 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar2 <> 0");
				$raw2 = mysqli_fetch_array($query2);

				$query3 = mysqli_query($conn, "SELECT AVG(rasio_solar3) AS rasio3 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar3 <> 0");
				$raw3 = mysqli_fetch_array($query3);

				if (($raw3['rasio3'] != 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2']+$raw3['rasio3'])/3;
				} elseif(($raw3['rasio3'] == 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2'])/2;
				} elseif (($raw3['rasio3'] == 0) && ($raw2['rasio2'] == 0)) {
					$avg = $raw1['rasio1'];
				}
			?>
			<tr>
				<td>
					Total Jarak Tempuh : <?php echo format_ribuan2($jartemp)." Km"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Total Pemakaian Solar : <?php echo format_ribuan2($solar)." Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rasio Solar : <?php echo format_ribuan2($rasio)." Km/Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rata-rata rasio yang dicatat di system : <?php echo format_ribuan2($avg)." Km/Litter"; ?>
				</td>
			</tr>
		</table>
		<?php } 
		elseif ($tgl5 != '' AND $tgl6 != '' AND $plat_no == '') {
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="40">Plat No</td>		
				<td width="80">Driver</td>		
				<td width="40">Km. Berangkat</td>
				<td width="60">Jam Berangkat</td>
				<td width="40">Km. Pulang</td>					
				<td width="60">Jam Pulang</td>
				<td width="30">Jarak Tempuh</td>
				<td width="40">Litter Solar</td>
				<td width="40">Km Solar</td>
				<td width="40">Rasio Solar</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND kilometer.jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY id_km DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo format_ribuan($r['km_brkt']);?></td>
				<td><?php echo tgl_indo2($r['jam_brkt']);?></td>
				<td><?php echo format_ribuan($r['km_plg']);?></td>
				<td><?php echo tgl_indo2($r['jam_plg']);?></td>
				<td><?php echo format_ribuan($r['jarak_tempuh']);?></td>
				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['solar_1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['solar_2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['solar_3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['km_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['km_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['km_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['rasio_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['rasio_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['rasio_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="10">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<table class="ttd">
			<?php
				$query = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS jarak_tempuh, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3 FROM kilometer WHERE jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$row = mysqli_fetch_array($query);
				$jartemp = $row['jarak_tempuh'];
				$solar = $row['solar_1'] + $row['solar_2'] + $row['solar_3'];
				$rasio = $jartemp/$solar;
				
				$query1 = mysqli_query($conn, "SELECT AVG(rasio_solar1) AS rasio1 FROM kilometer WHERE rasio_solar1 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw1 = mysqli_fetch_array($query1);

				$query2 = mysqli_query($conn, "SELECT AVG(rasio_solar2) AS rasio2 FROM kilometer WHERE rasio_solar2 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw2 = mysqli_fetch_array($query2);

				$query3 = mysqli_query($conn, "SELECT AVG(rasio_solar3) AS rasio3 FROM kilometer WHERE rasio_solar3 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw3 = mysqli_fetch_array($query3);

				if (($raw3['rasio3'] != 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2']+$raw3['rasio3'])/3;
				} elseif(($raw3['rasio3'] == 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2'])/2;
				} elseif (($raw3['rasio3'] == 0) && ($raw2['rasio2'] == 0)) {
					$avg = $raw1['rasio1'];
				}
			?>
			<tr>
				<td>
					Total Jarak Tempuh : <?php echo format_ribuan2($jartemp)." Km"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Total Pemakaian Solar : <?php echo format_ribuan2($solar)." Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rasio Solar : <?php echo format_ribuan2($rasio)." Km/Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rata-rata rasio yang dicatat di system : <?php echo format_ribuan2($avg)." Km/Litter"; ?>
				</td>
			</tr>
		</table>
		<?php }
		elseif ($tgl5 != '' AND $tgl6 != '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="40">Plat No</td>		
				<td width="80">Driver</td>		
				<td width="40">Km. Berangkat</td>
				<td width="60">Jam Berangkat</td>
				<td width="40">Km. Pulang</td>					
				<td width="60">Jam Pulang</td>
				<td width="30">Jarak Tempuh</td>
				<td width="40">Litter Solar</td>
				<td width="40">Km Solar</td>
				<td width="40">Rasio Solar</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND plat_no='$plat_no' AND kilometer.jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY id_km DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_peg'];?></td>
				<td><?php echo format_ribuan($r['km_brkt']);?></td>
				<td><?php echo tgl_indo2($r['jam_brkt']);?></td>
				<td><?php echo format_ribuan($r['km_plg']);?></td>
				<td><?php echo tgl_indo2($r['jam_plg']);?></td>
				<td><?php echo format_ribuan($r['jarak_tempuh']);?></td>
				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['solar_1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['solar_2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['solar_3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['solar_3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['km_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['km_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['km_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan($r['km_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>

				<td>
					<table style="margin-top: 0">
						<tr>
						<?php if ($r['rasio_solar1'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr>
					 	<tr>
						<?php if ($r['rasio_solar2'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
					 	</tr><tr>
						<?php if ($r['rasio_solar3'] != 0) { ?>
						 	<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
						<?php } else { ?>
						 	<td></td>
						<?php } ?>
						</tr>
					</table>
				</td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<td colspan="10">
				<?php $jmldata = mysqli_num_rows($query); echo "Jumlah Record"; ?>
				</td>
				<td align="right"><?php echo $jmldata;?></td>
			</tr>
		</table>
		<table class="ttd">
			<?php
				$pre_query = mysqli_query($conn, "SELECT id_mobil AS id_mobil FROM mobil WHERE plat_no = '$plat_no'");
				$pre_row = mysqli_fetch_array($pre_query);
				$id_mobil = $pre_row['id_mobil'];
				
				$query = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS jarak_tempuh, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3 FROM kilometer WHERE id_mobil='$id_mobil' AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$row = mysqli_fetch_array($query);
				$jartemp = $row['jarak_tempuh'];
				$solar = $row['solar_1'] + $row['solar_2'] + $row['solar_3'];
				$rasio = $jartemp/$solar;

				$query1 = mysqli_query($conn, "SELECT AVG(rasio_solar1) AS rasio1 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar1 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw1 = mysqli_fetch_array($query1);

				$query2 = mysqli_query($conn, "SELECT AVG(rasio_solar2) AS rasio2 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar2 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw2 = mysqli_fetch_array($query2);

				$query3 = mysqli_query($conn, "SELECT AVG(rasio_solar3) AS rasio3 FROM kilometer WHERE id_mobil='$id_mobil' AND rasio_solar3 <> 0 AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
				$raw3 = mysqli_fetch_array($query3);

				if (($raw3['rasio3'] != 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2']+$raw3['rasio3'])/3;
				} elseif(($raw3['rasio3'] == 0) && ($raw2['rasio2'] != 0)) {
					$avg = ($raw1['rasio1']+$raw2['rasio2'])/2;
				} elseif (($raw3['rasio3'] == 0) && ($raw2['rasio2'] == 0)) {
					$avg = $raw1['rasio1'];
				}
			?>
			<tr>
				<td>
					Total Jarak Tempuh : <?php echo format_ribuan2($jartemp)." Km"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Total Pemakaian Solar : <?php echo format_ribuan2($solar)." Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rasio Solar : <?php echo format_ribuan2($rasio)." Km/Litter"; ?>
				</td>
			</tr>
			<tr>
				<td>
					Rata-rata rasio yang dicatat di system : <?php echo format_ribuan2($avg)." Km/Litter"; ?>
				</td>
			</tr>
		</table>
		<?php }
		?>
	</div>
</body>
</html>