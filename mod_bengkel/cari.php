<?php
	include ("../config/koneksi.php");
	$kode_bkl = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_bengkel/aksi_bengkel.php";		
?>
<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kode_bkl; ?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head2">
				<td>No.</td>
				<td>Kode Bengkel</td>
				<td>Nama Bengkel</td>
				<td>Alamat</td>
				<td>No Telephone</td>
				<td>Contact Person</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bengkel WHERE kode_bkl LIKE '%".$kode_bkl."%' OR nama_bkl LIKE '%".$kode_bkl."%' OR alamat LIKE '%".$kode_bkl."%'");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($r = mysqli_fetch_array($query)) { ?>
				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['kode_bkl'];?></td>
					<td><?php echo $r['nama_bkl'];?></td>
					<td><?php echo $r['alamat'];?></td>
					<td><?php echo $r['no_telp'];?></td>
					<td><?php echo $r['contact_person'];?></td>
					<?php if ($akses != 3) { ?> 
					<td></td>
					<?php } else { ?>
					<td>
						<div class="btn-group">
							<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="media.php?module=data_bengkel&&act=edit&&kode_bkl=<?php echo $r['kode_bkl'];?>"><i class="icon-pencil"></i> Edit</a></li>
								<li><a href="<?php echo "$aksi?module=hapus&&kode_bkl=$r[kode_bkl]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data bengkel <?php echo $r['nama_bkl'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
					<?php } ?> 
				</tr>
		<?php $no++; }
			} else { ?>
				<tr>
					<td colspan="8"><div class="alert alert-error">Data tidak ditemukan</div></td>
				</tr>
		<?php } ?>
</div>