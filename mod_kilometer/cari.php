<?php
	include "../config/koneksi.php";
	include "../config/fungsi_indotgl.php";
	include "../config/fungsi_rupiah.php";

	$kode = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_kilometer/aksi_kilometer.php";
?>

<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kode;?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head2">
				<td>No.</td>
				<td>Plat No Mobil</td>
				<td>Driver</td>
				<td>Rayon</td>
				<td>Km Berangkat</td>
				<td>Jam Berangkat</td>
				<td>Km Pulang</td>
				<td>Jam Pulang</td>
				<td>Jarak Tempuh</td>
				<td>Litter Solar</td>
				<td>Km Solar</td>
				<td>Rasio Solar</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM kilometer, mobil, pegawai WHERE kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND mobil.plat_no LIKE '%".$kode."%' OR kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND pegawai.nama_peg LIKE '%".$kode."%' OR kilometer.id_mobil=mobil.id_mobil AND kilometer.id_peg=pegawai.id_peg AND kilometer.jam_brkt LIKE '%".$kode."%' ORDER BY id_km DESC");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($r = mysqli_fetch_array($query)) {
		?>
				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['plat_no'];?></td>
					<td><?php echo $r['nama_peg'];?></td>
					<td><?php echo $r['rayon'] ?></td>

					<?php if ($r['km_brkt'] == 0) { ?>
					<td>
						<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=km_awal&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'">Input Km</button>
					</td>
					<?php } else { ?>
					
					<td><?php echo format_ribuan($r['km_brkt']) ?></td>
					<?php } ?>
					
					<?php if ($r['jam_brkt'] == "0000-00-00 00:00:00") { ?>
					<td></td>
					<?php } else { ?>
					<td><?php echo tgl_indo2($r['jam_brkt']) ?></td>
					<?php } ?>

					<?php if ($r['km_plg'] == 0) { ?>
					<td>
						<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=km_akhir&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($r['km_brkt'] == 0) { ?> disabled <?php } ?>>Input Km</button>
					</td>
					<?php } else { ?>
					<td><?php echo format_ribuan($r['km_plg']) ?></td>
					<?php } ?>
					
					<?php if ($r['jam_plg'] == "0000-00-00 00:00:00") { ?>
					<td></td>
					<?php } else { ?>
					<td><?php echo tgl_indo2($r['jam_plg']) ?></td>
					<?php } ?>

					<td><?php echo format_ribuan($r['jarak_tempuh']).' Km';?></td>
					<td>

					<?php if ($akses != 4) { ?>
						<table>
							<tr>
								<?php if ($r['solar_1'] == 0) { 
									$filter = mysqli_query($conn, "SELECT MAX(km_solar1) max_km_solar1 FROM kilometer WHERE id_mobil = '$r[id_mobil]'");
									$row = mysqli_fetch_array($filter);
								?>						
								<td>
									<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar1&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['km_plg'] == 0 || ($row['max_km_solar1'] > $r['km_brkt'])) { ?> disabled <?php } ?>>Input Solar 1</button>
								</td>
							
								<?php } else { ?>
							
								<td><?php echo format_ribuan2($r['solar_1']);?></td>
								<?php } ?>
							</tr>

							<tr>
							<?php if ($r['solar_1'] == 0) { ?>
								<td></td>
							<?php }  else if (($r['solar_1'] != 0) && ($r['solar_2'] == 0)) { ?>
							
								<td>
									<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar2&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['rasio_solar1'] != 0) { ?> disabled <?php } ?>>Input Solar 2</button>
								</td>
							
								<?php } else if ($r['solar_2'] != 0) { ?>
							
								<td><?php echo format_ribuan2($r['solar_2']);?></td>
							
								<?php } ?>
							</tr>

							<tr>
							<?php if ($r['solar_2'] == 0) { ?>
								<td></td>
							<?php } else if (($r['solar_2'] != 0) && ($r['solar_3'] == 0)) { ?>
							
								<td>
									<button class="btn btn-warning" onclick="window.location='media.php?module=kilometer&&act=input_solar3&&id_km=<?php echo $r['id_km'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($akses == 4 || $r['rasio_solar2'] != 0) { ?> disabled <?php } ?>>Input Solar 3</button>
								</td>
							
								<?php } else if ($r['solar_3'] != 0) { ?>
							
								<td><?php echo format_ribuan2($r['solar_3']);?></td>
							
								<?php } ?>
							</tr>
						</table>
					<?php } ?>
					</td>

					<td>
					<?php if ($akses != 4) { ?>
						<table>
							<tr>
							<?php if ($r['km_solar1'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan($r['km_solar1']) ?></td>
							<?php } ?>
							</tr>
							<tr>
							<?php if ($r['km_solar2'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan($r['km_solar2']) ?></td>
							<?php } ?>
							</tr>
							<tr>
							<?php if ($r['km_solar3'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan($r['km_solar3']) ?></td>
							<?php } ?>
							</tr>
						</table>
					<?php } ?>
					</td>

					<td>
					<?php if ($akses != 4) { ?>
						<table>
							<tr>
							<?php if ($r['rasio_solar1'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan2($r['rasio_solar1']) ?></td>
							<?php } ?>
							</tr>
							<tr>
							<?php if ($r['rasio_solar2'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan2($r['rasio_solar2']) ?></td>
							<?php } ?>
							</tr>
							<tr>
							<?php if ($r['rasio_solar3'] == 0) { ?>
								<td></td>
							<?php } else { ?>
								<td><?php echo format_ribuan2($r['rasio_solar3']) ?></td>
							<?php } ?>
							</tr>
						</table>
					<?php } ?>
					</td>

					<?php if ($akses == 3 OR $akses == 2) { ?>
					<td>
						<div class="btn-group">
							<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">

								<li><a href="<?php echo "$aksi?module=hapus&&id_km=$r[id_km]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data Kilometer <?php echo $r['plat_no'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
					<?php } else { ?> <td></td> <?php } ?>
				</tr>
			<?php $no++; }
			 } else { ?>
			 	<tr>
					<td colspan="13"><div class="alert alert-error">Data tidak ditemukan</div></td>
				</tr>
			<?php
			 }
			?>
				<tr>
					<td colspan="12">
						<td>Jumlah Record <?php echo $num;?></td>
					</td>
				</tr>
		</tbody>
	</table>
</div>