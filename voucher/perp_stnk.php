<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$kode_perp_stnk = $_GET['kode_perp_stnk'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Voucher Perp. STNK</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ SURAT PERINTAH KERJA PERPANJANGAN STNK ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<?php
			$query = mysqli_query($conn, "SELECT * FROM perp_stnk, mobil, pegawai, direktorat WHERE kode_perp_stnk='$kode_perp_stnk' AND perp_stnk.id_mobil=mobil.id_mobil  AND mobil.id_peg=pegawai.id_peg AND pegawai.id_dir=direktorat.id_dir");
			$r = mysqli_fetch_array($query);
		?>	
		<table style="border: 0px">
			<tr>
				<td>
					<table class="table">
						<tr>
							<td style="width: 60px">Kode Voucher</td>
							<td>:</td>
							<td><?php echo $r['kode_perp_stnk']; ?></td>
						</tr>
						<tr>
							<td style="width: 60px">Plat No Mobil</td>
							<td>:</td>
							<td><?php echo $r['plat_no']; ?></td>
						</tr>
						<tr>
							<td style="width: 60px">Jenis Mobil</td>
							<td>:</td>
							<td><?php echo $r['type']; ?></td>
						</tr>
					</table>
				</td>
				<td>
					<table class="table tbl2">						
						<tr>
							<td style="width: 60px">Request Date</td>
							<td>:</td>
							<td><?php echo tgl_indo($r['req_date']); ?></td>
						</tr>
						<tr>
							<td style="width: 60px">Approve 1 Date</td>
							<td>:</td>
							<td><?php echo tgl_indo($r['app1_date']); ?></td>
						</tr>
						<tr>
							<td style="width: 60px">Approve 2 Date</td>
							<td>:</td>
							<td><?php echo tgl_indo($r['app2_date']); ?></td>
						</tr>
					</table>
				</td>
				<td>
					<table class="table tbl2">
						<tr>
							<td style="width: 60px">Nama Pemilik</td>
							<td>:</td>
							<td><?php echo $r['nama_peg']; ?></td>
						</tr>
						<tr>
							<td style="width: 50px">Direktorat</td>
							<td>:</td>
							<td><?php echo $r['deskripsi']; ?></td>
						</tr>
						<tr>
							<td style="width: 50px">Jabatan</td>
							<td>:</td>
							<td><?php echo $r['jabatan']; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br><br>
		<table class="table">			
			<tr>
				<td width="20" align="center">No.</td>
				<td width="390" align="center">Jenis Request</td>
				<td width="170" align="center">Harga</td>
			</tr>
			<tr>
				<td><?php echo "1."; ?></td>
				<td><?php echo "Perpanjangan STNK" ?></td>
				<td align="right"><?php echo format_rupiah($r['cost_est']) ?></td>
			</tr>
		</table>
		<table class="ttd">
			<tr>
				<td style="width:200px;" align="center">Dibuat Oleh
				<br><br><br><br><br><br>
				<?php
					$kode_user = $r['kodeuser'];
					$query = mysqli_query($conn, "SELECT * FROM user_man WHERE kodeUser='$kode_user'");
					$user = mysqli_fetch_array($query);
					echo $user['first_name']." ".$user['last_name'];
				?>
				</td>
				<td style="width:200px;" align="center">Disetujui
				<br><br><br><br><br><br>
				Didi Wulyanto</td>
			</tr>
		</table>
	</div>
</body>
</html>