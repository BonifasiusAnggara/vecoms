<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$datetime1 = $tgl1." 00:00:00";
	$datetime2 = $tgl2." 23:59:59";
	$plat_no = $_GET['plat_no'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Ganti Sparepart</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ GANTI SPAREPART ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<h6>
		<?php
			if ($tgl1 == '' AND $tgl2 == '') {

			} else {
				echo "Periode"."&nbsp;".": ".tgl_indo($tgl1)." s/d ".tgl_indo($tgl2);
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
		if ($tgl1 == '' AND $tgl2 == '' AND $plat_no == '') { 			
		?>
		<table class="table">
			<tr>
				<td>No.</td>
				<td>Kode Voucher</td>
				<td>Plat No Mobil</td>
				<td>Nama Bengkel</td>
				<td>Jenis Sparepart</td>
				<td>Tanggal Request</td>
				<td>Status</td>
				<td>Estimasi Biaya</td>
				<td>Realisasi Biaya</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, bengkel, pegawai WHERE ganti_sparepart.id_mobil=mobil.id_mobil AND ganti_sparepart.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg ORDER BY id_spr DESC");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['kode_spr'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_bkl'];?></td>
				<td>
					<table style="margin-top: 0px;">
						<tr>
							<td>Nama Sparepart</td>
							<td>Jumlah</td>
							<td>Harga</td>
						</tr>
					<?php
						$kode_spr = $r['kode_spr'];
						$query2 = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE detail_gs.kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
						while ($det = mysqli_fetch_array($query2)) { ?>
						<tr>
							<td width="50"><?php echo $det['nama_sprt'] ?></td>
							<td width="10" align="right"><?php echo $det['jumlah'] ?></td>
							<td align="right"><?php echo format_rupiah($det['harga_sprt']*$det['jumlah']) ?></td>
						</tr>
					<?php }
					?>
					</table>
				</td>
				<td><?php echo $r['req_date'];?></td>
				<td><?php echo $r['status'];?></td>

				<td align="right">
				<?php
					$total_harga = $r['cost_est'];
					echo format_rupiah($total_harga);
				?>
				</td>
				<td align="right"><?php echo format_rupiah($r['cost_real']) ?></td>
			</tr>
			<?php $no++; } ?>
		</table>
		<?php } 
		elseif ($tgl1 != '' AND $tgl2 != '' AND $plat_no == '') {
		?>
		<table class="table">
			<tr>
				<td>No.</td>
				<td>Kode Voucher</td>
				<td>Plat No Mobil</td>
				<td>Bengkel</td>
				<td>Jenis Sparepart</td>
				<td>Tanggal Request</td>
				<td>Status</td>
				<td>Estimasi Biaya</td>
				<td>Realisasi Biaya</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, bengkel, pegawai WHERE ganti_sparepart.id_mobil=mobil.id_mobil AND ganti_sparepart.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND ganti_sparepart.req_date BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY req_date");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['kode_spr'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_bkl'];?></td>
				<td>
					<table style="margin-top: 0px;">
						<tr>
							<td>Nama Sparepart</td>
							<td>Jumlah</td>
							<td>Harga</td>
						</tr>
					<?php
						$kode_spr = $r['kode_spr'];
						$query2 = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE detail_gs.kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
						while ($det = mysqli_fetch_array($query2)) { ?>
						<tr>
							<td width="50"><?php echo $det['nama_sprt'] ?></td>
							<td width="10" align="right"><?php echo $det['jumlah'] ?></td>
							<td align="right"><?php echo format_rupiah($det['harga_sprt']*$det['jumlah']) ?></td>
						</tr>
					<?php }
					?>
					</table>
				</td>
				<td><?php echo $r['req_date'];?></td>
				<td><?php echo $r['status'];?></td>

				<td align="right">
				<?php
					$total_harga = $r['cost_est'];
					echo format_rupiah($total_harga);
				?>
				</td>
				<td align="right"><?php echo format_rupiah($r['cost_real']) ?></td>
			</tr>
			<?php $no++; } ?>
		</table>
		<?php } 
		elseif ($tgl1 == '' AND $tgl2 == '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td>No.</td>
				<td>Kode Voucher</td>
				<td>Plat No Mobil</td>
				<td>Bengkel</td>
				<td>Jenis Sparepart</td>
				<td>Tanggal Request</td>
				<td>Status</td>
				<td>Estimasi Biaya</td>
				<td>Realisasi Biaya</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, bengkel, pegawai WHERE ganti_sparepart.id_mobil=mobil.id_mobil AND ganti_sparepart.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND plat_no='$plat_no' ORDER BY req_date");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['kode_spr'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_bkl'];?></td>
				<td>
					<table style="margin-top: 0px;">
						<tr>
							<td>Nama Sparepart</td>
							<td>Jumlah</td>
							<td>Harga</td>
						</tr>
					<?php
						$kode_spr = $r['kode_spr'];
						$query2 = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE detail_gs.kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
						while ($det = mysqli_fetch_array($query2)) { ?>
						<tr>
							<td width="50"><?php echo $det['nama_sprt'] ?></td>
							<td width="10" align="right"><?php echo $det['jumlah'] ?></td>
							<td align="right"><?php echo format_rupiah($det['harga_sprt']*$det['jumlah']) ?></td>
						</tr>
					<?php }
					?>
					</table>
				</td>
				<td><?php echo $r['req_date'];?></td>
				<td><?php echo $r['status'];?></td>

				<td align="right">
				<?php
					$total_harga = $r['cost_est'];
					echo format_rupiah($total_harga);
				?>
				</td>
				<td align="right"><?php echo format_rupiah($r['cost_real']) ?></td>
			</tr>
			<?php $no++; } ?>
		</table>
		<?php }
		elseif ($tgl1 != '' AND $tgl2 != '' AND $plat_no != '') { 			
		?>
		<table class="table">
			<tr>
				<td>No.</td>
				<td>Kode Voucher</td>
				<td>Plat No Mobil</td>
				<td>Bengkel</td>
				<td>Jenis Sparepart</td>
				<td>Tanggal Request</td>
				<td>Status</td>
				<td>Estimasi Biaya</td>
				<td>Realisasi Biaya</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, bengkel, pegawai WHERE ganti_sparepart.id_mobil=mobil.id_mobil AND ganti_sparepart.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND plat_no='$plat_no' AND ganti_sparepart.req_date BETWEEN '".$datetime1."' AND '".$datetime2."' ORDER BY req_date");
				$no = 1;
				while ($r = mysqli_fetch_array($query)) { ?>
			<tr>
				<td><?php echo $no.".";?></td>
				<td><?php echo $r['kode_spr'];?></td>
				<td><?php echo $r['plat_no'];?></td>
				<td><?php echo $r['nama_bkl'];?></td>
				<td>
					<table style="margin-top: 0px;">
						<tr>
							<td>Nama Sparepart</td>
							<td>Jumlah</td>
							<td>Harga</td>
						</tr>
					<?php
						$kode_spr = $r['kode_spr'];
						$query2 = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE detail_gs.kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
						while ($det = mysqli_fetch_array($query2)) { ?>
						<tr>
							<td width="50"><?php echo $det['nama_sprt'] ?></td>
							<td width="10" align="right"><?php echo $det['jumlah'] ?></td>
							<td align="right"><?php echo format_rupiah($det['harga_sprt']*$det['jumlah']) ?></td>
						</tr>
					<?php }
					?>
					</table>
				</td>
				<td><?php echo $r['req_date'];?></td>
				<td><?php echo $r['status'];?></td>

				<td align="right">
				<?php
					$total_harga = $r['cost_est'];
					echo format_rupiah($total_harga);
				?>
				</td>
				<td align="right"><?php echo format_rupiah($r['cost_real']) ?></td>
			</tr>
			<?php $no++; } ?>
		</table>
		<?php }
		?>
	</div>
</body>
</html>