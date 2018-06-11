<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$yeardate = date("Y-m-d");
	$yearmonth = $_GET['yearmonth'];

	if ($yearmonth == '') {
		$datetime1 = $yeardate."-01 00:00:00";
		$datetime2 = $yeardate."-31 23:59:59";
	} elseif ($yearmonth != '') {
		$datetime1 = $yearmonth."-01 00:00:00";
		$datetime2 = $yearmonth."-31 23:59:59";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Laporan Statistik</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ STATISTIK ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<h6>Print Date : <?php echo tgl_indo($yeardate); ?></h6>
		<h6>
		<?php
			if ($yearmonth == '') {
				echo "Periode"."&nbsp;".": ".tgl_indo($yeardate);
			} else {
				echo "Periode"."&nbsp;".": ".tgl_indo($yearmonth);
			}
		?>
		</h6>
		
		<table class="table">
			<tr>
				<td width="10">No.</td>
				<td width="80">Plat No</td>
				<td width="100">Owner</td>
				<td width="60">Jarak Tempuh</td>
				<td width="60">Konsumsi BBM</td>
				<td width="60">Rasio BBM <sup>(km / litter)</sup></td>
				<td width="60">Biaya BBM</td>
				<td width="60">Biaya Service</td>
				<td width="60">Biaya Sparepart</td>
			</tr>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg");
				$no = 1;
				while ($mbl = mysqli_fetch_array($query)) { ?>
			<tr>
				<?php
					$query1 = mysqli_query($conn, "SELECT SUM(jarak_tempuh) AS  jar_temp, SUM(solar_1) AS solar_1, SUM(solar_2) AS solar_2, SUM(solar_3) AS solar_3, SUM(harga_solar1) AS harga_solar1, SUM(harga_solar2) AS harga_solar2, SUM(harga_solar3) AS harga_solar3 FROM kilometer WHERE id_mobil = '$mbl[id_mobil]' AND jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$km = mysqli_fetch_array($query1);

					$query4 = mysqli_query($conn, "SELECT SUM(bensin) AS total_bensin, SUM(harga) AS total_harga FROM bensin WHERE id_mobil = '$mbl[id_mobil]' AND tgl_isi BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$bns = mysqli_fetch_array($query4);

					if ($mbl['type_code'] == 1) :
						$total_bbm = $km['solar_1']+$km['solar_2']+$km['solar_3'];
					elseif ($mbl['type_code'] == 2) : 
						$total_bbm = $bns['total_bensin'];
					endif;
					
					if ($mbl['type_code'] == 1 && $total_bbm != 0) :
						$rasio_bbm = $km['jar_temp']/$total_bbm;
					elseif ($mbl['type_code'] == 2) :
						$rasio_bbm = 0;
					endif;

					if ($mbl['type_code'] == 1) :
						$total_harga = $km['harga_solar1']+$km['harga_solar2']+$km['harga_solar3'];
					elseif ($mbl['type_code'] == 2) :
						$total_harga = $bns['total_harga'];
					endif;

					$query2 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM service WHERE id_mobil = '$mbl[id_mobil]' AND app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$svc = mysqli_fetch_array($query2);

					$query3 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM ganti_sparepart WHERE id_mobil = '$mbl[id_mobil]' AND app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$spr = mysqli_fetch_array($query3);
				?>
				<td><?php echo $no.".";?></td>
				<td><?php echo $mbl['plat_no'];?></td>
				<td><?php echo $mbl['nama_peg'];?></td>									
				<td><?php echo format_ribuan($km['jar_temp']);?></td>
				<td><?php echo format_ribuan2($total_bbm);?></td>
				<td><?php echo format_ribuan2($rasio_bbm);?></td>
				<td><?php echo format_rupiah($total_harga);?></td>
				<td><?php echo format_rupiah($svc['biaya']);?></td>
				<td><?php echo format_rupiah($spr['biaya']);?></td>
			</tr>
			<?php $no++; } ?>

			<tr>
				<?php
					$query1 = mysqli_query($conn, "SELECT SUM(harga_solar1) AS harga_solar1, SUM(harga_solar2) AS harga_solar2, SUM(harga_solar3) AS harga_solar3 FROM kilometer WHERE jam_brkt BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$km = mysqli_fetch_array($query1);

					$query2 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM service WHERE app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$svc = mysqli_fetch_array($query2);

					$query3 = mysqli_query($conn, "SELECT SUM(cost_est) AS biaya FROM ganti_sparepart WHERE app2_date BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$spr = mysqli_fetch_array($query3);

					$query4 = mysqli_query($conn, "SELECT SUM(harga) AS total_harga FROM bensin WHERE tgl_isi BETWEEN '".$datetime1."' AND '".$datetime2."'");
					$bns = mysqli_fetch_array($query4);

					$total_harga = $km['harga_solar1']+$km['harga_solar2']+$km['harga_solar3']+$bns['total_harga'];
				?>
				<td colspan="6">Total</td>
				<td><?php echo format_rupiah($total_harga)?></td>
				<td><?php echo format_rupiah($svc['biaya'])?></td>
				<td><?php echo format_rupiah($spr['biaya'])?></td>
			</tr>
		</table>
	</div>
</body>
</html>