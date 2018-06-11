<?php
	include ("../config/koneksi.php");
	include "../config/fungsi_indotgl.php";
	include "../config/fungsi_rupiah.php";
	
	$kode = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_bensin/aksi_bensin.php";		
?>
<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kode; ?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head">
				<td>No.</td>
				<td>Plat No Mobil</td>
				<td>Owner Mobil</td>
				<td>Litter Bensin</td>
				<td>Km Bensin</td>
				<td>Harga Bensin</td>
				<td>Tanggal Isi</td>
				<td>Rasio Bensin</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM bensin, mobil, pegawai WHERE bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg AND mobil.plat_no LIKE '%".$kode."%' OR bensin.id_mobil=mobil.id_mobil AND bensin.id_peg=pegawai.id_peg AND pegawai.nama_peg LIKE '%".$kode."%' ORDER BY id_bensin DESC");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($r = mysqli_fetch_array($query)) { ?>
				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['plat_no'];?></td>
					<td><?php echo $r['nama_peg'];?></td>
					<td><?php echo format_ribuan2($r['bensin']) ?></td>
					<td><?php echo format_ribuan($r['km_bensin'])?></td>
					<td><?php echo format_rupiah($r['harga'])?></td>
					<td><?php echo tgl_indo($r['tgl_isi'])?></td>
					<td><?php echo format_ribuan2($r['rasio'])?></td>

					<?php if ($akses == 3 OR $akses == 2) { ?>
					<td>
						<div class="btn-group">
							<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo "$aksi?module=hapus&&id_bensin=$r[id_bensin]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data Bensin<?php echo $r['plat_no'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
					<?php } else { ?> <td></td> <?php } ?> 
				</tr>
		<?php $no++; }
			} else { ?>
				<tr>
					<td colspan="8"><div class="alert alert-error">Data tidak ditemukan</div></td>
				</tr>
		<?php } ?>
				<tr>
					<td colspan="8">
						<td>Jumlah Record <?php echo $num;?></td>
					</td>
				</tr>
		</tbody>
	</table>
</div>