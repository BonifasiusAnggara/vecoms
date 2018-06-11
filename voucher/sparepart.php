<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	include ("../config/fungsi_rupiah.php");

	$kode_spr = $_GET['kode_spr'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Voucher Ganti Sparepart</title>
	<link rel="shortcut icon" type="text/css" href="../assets/images/Logo Enseval Crop.jpg">
	<link rel="stylesheet" type="text/css" href="voucher.css">
</head>
<body>
	<div class="page">
		<div class="kop">
			<img src="../assets/logo/logo-enseval.png" style="width: 120px; height: 80px;" id="kop">
			<div class="header">
				<h2> ~ SURAT PERINTAH KERJA GANTI SPAREPART ~ </h2>
				<h4>PT. ENSEVAL PUTERA MEGATRADING, TBK. CAB. SUKABUMI</h4>
				<h6>Jalan Raya Cibolang No. 21 RT 04 RW 02 Desa Cibolang Kaler</h6>
				<h6>Kecamataan Cisaat Kabupaten Sukabumi</h6>
			</div>
		</div>
		<hr style="border: solid 3px #0B8D45;">
		<?php
			$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, pegawai, direktorat WHERE kode_spr='$kode_spr' AND ganti_sparepart.id_mobil=mobil.id_mobil  AND mobil.id_peg=pegawai.id_peg AND pegawai.id_dir=direktorat.id_dir");
			$alamat_bkl = mysqli_query($conn, "SELECT * FROM ganti_sparepart, bengkel WHERE kode_spr='$kode_spr' AND ganti_sparepart.id_bkl=bengkel.id_bkl");
			$r = mysqli_fetch_array($query);
			$s = mysqli_fetch_array($alamat_bkl);
		?>	
		<table style="border: 0px">
			<tr>
				<td>
					<table class="table">
						<tr>
							<td style="width: 60px">Kode Voucher</td>
							<td>:</td>
							<td><?php echo $r['kode_spr']; ?></td>
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
							<td style="width: 60px">Bengkel</td>
							<td>:</td>
							<td><?php echo $s['nama_bkl']; ?></td>
						</tr>
						<tr>
							<td style="width: 60px">Alamat</td>
							<td>:</td>
							<td><?php echo $s['alamat']; ?></td>
						</tr>						
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
						<tr>
							<td style="width: 60px">Approve 2 Date</td>
							<td>:</td>
							<td><?php echo tgl_indo($r['app2_date']); ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br><br>
		<table class="table">			
			<tr>
				<td width="20" align="center">No.</td>
				<td width="270" align="center">Nama Sparepart</td>
				<td width="100" align="center">Jumlah</td>
			</tr>
			<?php
				$query = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
				$no = 1;
				while ($row = mysqli_fetch_array($query)) {
			?>
			<tr>
				<td><?php echo $no."."; ?></td>
				<td><?php echo $row['nama_sprt'] ?><?php if ($row['nama_sprt'] == 'Ban') { ?> <sup><b>(<?php echo $row['arr_kode_ban'] ?>)</b></sup> <?php } ?></td>
				<td align="right"><?php echo $row['jumlah'] ?></td>
			</tr>
			<?php $no++; } ?>
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