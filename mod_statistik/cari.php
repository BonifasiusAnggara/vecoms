<?php
	include ("../config/koneksi.php");
	include "../config/fungsi_indotgl.php";
	include "../config/fungsi_rupiah.php";
	$kode = $_POST['q'];
?>
<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kode; ?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head3">
				<td>No.</td>
				<td>Plat No</td>
				<td>Owner</td>
				<td>Jarak Tempuh</td>
				<td>Konsumsi BBM</td>
				<td>Rasio BBM <sup>(km / litter)</sup></td>
				<td>Biaya BBM</td>
				<td>Biaya Service</td>
				<td>Biaya Sparepart</td>
			</tr>
		</thead>
		<tbody>
		<?php
			$yearmonth = date("Y-m");
			$datetime1 = $yearmonth."-01 00:00:00";
			$datetime2 = $yearmonth."-31 23:59:59";
			$query = mysqli_query($conn, "SELECT * FROM mobil, pegawai WHERE mobil.id_peg=pegawai.id_peg AND mobil.plat_no LIKE '%".$kode."%' OR mobil.id_peg=pegawai.id_peg AND pegawai.nama_peg LIKE '%".$kode."%'");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($mbl = mysqli_fetch_array($query)) {
		?>
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
						elseif ($total_bbm == 0) :
							$rasio_bbm = 0;
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
					<td><?php echo format_ribuan($km['jar_temp'])." Km";?></td>
					<td><?php echo format_ribuan2($total_bbm)." Lt";?></td>
					<td><?php echo format_ribuan2($rasio_bbm)." Km/Lt";?></td>
					<td><?php echo format_rupiah($total_harga);?></td>
					<td><?php echo format_rupiah($svc['biaya']);?></td>
					<td><?php echo format_rupiah($spr['biaya']);?></td> 
				</tr>
			<?php $no++; } } else { ?>
				<tr>
					<td colspan="9"><div class="alert alert-error">Data tidak ditemukan</div></td>
				</tr>
		<?php } ?>
</div>