<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");

	$kode = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_mobil/aksi_mobil.php";
?>

	<div class="hasil_cari">
		<h5>Hasil Pencarian <b><?php echo $kode;?></b></h5>
		<table class="table table-striped">
			<thead>
				<tr class="head1">
					<td>No.</td>
					<td>Plat No</td>
					<td>Direktorat</td>
					<td>Nama Pemilik</td>
					<td>Jabatan</td>
					<td>Type</td>
					<td>Masa Berlaku STNK</td>
					<td>Masa Berlaku KEUR</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = mysqli_query($conn, "SELECT * FROM mobil, direktorat, pegawai WHERE mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg AND mobil.plat_no LIKE '%".$kode."%' OR mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg AND pegawai.nama_peg LIKE '%".$kode."%' OR mobil.id_dir=direktorat.id_dir AND mobil.id_peg=pegawai.id_peg AND direktorat.deskripsi LIKE '%".$kode."%'");
				$no = 1;
				$num = mysqli_num_rows($query);
				if ($num >= 1) {
					while ($r = mysqli_fetch_array($query)) {
			?>
				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['plat_no'];?></td>
					<td><?php echo $r['deskripsi'];?></td>
					<td><?php echo $r['nama_peg'];?></td>
					<td><?php echo $r['jabatan'];?></td>
					<td><?php echo $r['type'];?></td>
					<?php if ($r['ms_ber_stnk'] == 0000-00-00) { ?>
					<td></td>
					<?php } else { ?>
					<td><?php echo tgl_indo($r['ms_ber_stnk']);?></td>
					<?php } ?>
					<?php if ($r['ms_ber_keur'] == 0000-00-00) { ?>
					<td></td>
					<?php } else { ?>
					<td><?php echo tgl_indo($r['ms_ber_keur']);?></td>
					<?php } ?>
					<?php if ($akses != 3) { ?> 
					<td></td>
					<?php } else { ?>
					<td>
						<div class="btn-group">
							<a class="btn btn-primary" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li>
									<a href="media.php?module=data_mobil&&act=edit&&id_mobil=<?php echo $r['id_mobil'];?>"><i class="icon-pencil"></i> Edit</a>
								</li>
								<li>
									<a href="<?php echo "$aksi?module=hapus&&id_mobil=$r[id_mobil]";?>" onclick="return confirm('Apakah anda yakin ingin menghapus data mobil <?php echo $r['plat_no'];?> ??')"><i class="icon-trash"></i> Delete</a>
								</li>
							</ul>
						</div>
					</td>
					<?php } ?>
				</tr>
			<?php $no++;
					}
				} else {
			?>
				<tr><td colspan="11"><div class="alert alert-error">Data tidak ditemukan</div></td></tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>