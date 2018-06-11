<?php
	include ("../config/koneksi.php");
	include ("../config/fungsi_indotgl.php");
	$kodepegawai = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_pegawai/aksi_pegawai.php";
?>

<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kodepegawai; ?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head1">
				<td>No.</td>			
				<td>NIP</td>
				<td>Nama Pegawai</td>								
				<td>Direktorat</td>								
				<td>Jabatan</td>								
				<td>Tanggal Lahir</td>
				<td>Alamat</td>
				<td>No HP</td>
				<td></td>
			</tr>
		</thead>

		<tbody>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM pegawai, direktorat WHERE pegawai.NIP LIKE '%".$kodepegawai."%' AND pegawai.id_dir=direktorat.id_dir OR nama_peg LIKE '%".$kodepegawai."%' AND pegawai.id_dir=direktorat.id_dir OR direktorat.deskripsi LIKE '%".$kodepegawai."%' AND pegawai.id_dir=direktorat.id_dir");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($r = mysqli_fetch_array($query)) { ?> 
				<tr>
					<td><?php echo $no."."; ?></td>
					<td><?php echo $r['NIP']; ?></td>
					<td><?php echo $r['nama_peg']; ?></td>
					<td><?php echo $r['deskripsi']; ?></td>
					<td><?php echo $r['jabatan']; ?></td>
					<td><?php echo tgl_indo($r['tgl_lhr']); ?></td>
					<td><?php echo $r['alamat']; ?></td>
					<td><?php echo $r['no_hp'] ?></td>
					<?php if ($akses != 3) { ?> 
					<td></td>
					<?php } else { ?>
					<td>
						<div class="btn-group">
							<a class="btn btn-primary" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="media.php?module=data_pegawai&&act=edit&&id_pegawai=<?php echo $r['id_peg'] ?>"><i class="icon-pencil"></i> Edit</a></li>
								<li><a href="<?php echo "$aksi?module=hapus&&id_pegawai=$r[id_peg]"; ?>" onclick="return confirm('Apakah Anda yakin, ingin menghapus data pegawai <?php echo $r['nama_peg']; ?> ?')"><i class="icon-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
					<?php } ?>
				</tr>
		<?php $no++;	}
			} else { ?> 
				<tr>
					<td colspan="11"><div class="alert alert-error">Data tidak ditemukan</div></td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
</div>