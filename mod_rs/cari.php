<?php
	include "../config/koneksi.php";
	include "../config/fungsi_indotgl.php";
	include "../config/fungsi_rupiah.php";

	$kode = $_POST['q'];
	$akses = $_POST['akses'];
	$aksi = "mod_rs/aksi_rs.php";
?>

<div class="hasil_cari">
	<h5>Hasil Pencarian <b><?php echo $kode;?></b></h5>

	<table class="table table-striped">
		<thead>
			<tr class="head2">
				<td>No.</td>
				<td>Kode Service</td>
				<td>Plat No Mobil</td>
				<td>Nama Pemilik</td>
				<td>Bengkel</td>
				<td>Jenis Service</td>
				<td>Tanggal Request</td>
				<td>Status</td>
				<td>Tanggal Approve</td>
				<td>Estimasi Biaya</td>
				<td>Realisasi Biaya</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php
			$query = mysqli_query($conn, "SELECT * FROM service, mobil, bengkel, pegawai WHERE service.id_mobil=mobil.id_mobil AND service.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND kode_svc LIKE '%".$kode."%' OR service.id_mobil=mobil.id_mobil AND service.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND plat_no LIKE '%".$kode."%' OR service.id_mobil=mobil.id_mobil AND service.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND nama_peg LIKE '%".$kode."%' OR service.id_mobil=mobil.id_mobil AND service.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg AND nama_bkl LIKE '%".$kode."%'");
			$no = 1;
			$num = mysqli_num_rows($query);
			if ($num >= 1) {
				while ($r = mysqli_fetch_array($query)) { ?>

				<tr>
					<td><?php echo $no.".";?></td>
					<td><?php echo $r['kode_svc'];?></td>
					<td><?php echo $r['plat_no'];?></td>
					<td><?php echo $r['nama_peg'];?></td>
					<td><?php echo $r['nama_bkl'];?></td>
					<td>
						<button class="btn btn-warning" onclick="window.location='media.php?module=service_mobil&&act=input_service&&kode_svc=<?php echo $r['kode_svc'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($r['status'] != "REQUESTED") { ?> disabled <?php } ?>><i class="icon-wrench icon-white"></i> Input Service</button>
					</td>
					<td><?php echo $r['req_date'];?></td>
					<td><?php echo $r['status'];?></td>

					<?php if ($r['status'] == 'REQUESTED') { ?>
					<td></td>
					<?php } else if ($r['status'] == 'APPROVED_1') { ?>
					<td><?php echo $r['app1_date'];?></td>
					<?php } else if ($r['status'] == 'APPROVED_2') { ?>
					<td><?php echo $r['app2_date'];?></td>
					<?php } else if ($r['status'] == 'CLOSED') { ?>
					<td><?php echo $r['closed_date'];?></td>
					<?php } ?>

					<td><?php echo format_rupiah($r['cost_est']); ?></td>

					<?php if ($r['cost_real'] == 0) { ?>
					<td>
						<button class="btn btn-warning" onclick="window.location='media.php?module=service_mobil&&act=cost_real&&kode_svc=<?php echo $r['kode_svc'] ?>'" <?php if ($r['status'] != 'APPROVED_2') { ?> disabled <?php } ?>>Input Realisasi Biaya</button>
					</td>
					<?php } else { ?>
					<td><?php echo format_rupiah($r['cost_real']) ?></td>
					<?php } ?>

					<td>
						<div class="btn-group">
							<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="media.php?module=service_mobil&&act=detail&&kode_svc=<?php echo $r['kode_svc'];?>&&id_mobil=<?php echo $r['id_mobil'] ?>"><i class="icon-wrench"></i> Detail</a></li>

								<?php if (($r['status'] == 'REQUESTED') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
								<li><a href="<?php echo "$aksi?module=approve_1&&kode_svc=$r[kode_svc]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui pengajuan service <?php echo $r['kode_svc'] ?> ?')"><i class="icon-pencil"></i> Approve_1</a></li>
								<?php } ?>

								<?php if (($r['status'] == 'APPROVED_1') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
								<li><a href="<?php echo "$aksi?module=approve_2&&kode_svc=$r[kode_svc]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui pengajuan service <?php echo $r['kode_svc'] ?> ?')"><i class="icon-pencil"></i> Approve_2</a></li>
								<?php } ?>

								<?php if ($akses == 3) { ?>
								<li><a href="<?php echo "$aksi?module=hapus&&kode_svc=$r[kode_svc]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data service <?php echo $r['kode_svc'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
								<?php } ?>
								
								<?php if ($r['status'] == 'APPROVED_2') { ?>
								<li><a href="voucher/v_service.php?kode_svc=<?php echo $r['kode_svc'] ?>" onclick="window.location='voucher/v_service.php?kode_svc=<?php echo $r['kode_svc'] ?>"><i class="icon-print"></i> Print</a></li>
								<?php } ?>

								<?php if (($r['status'] == 'APPROVED_2') && (($akses == 3) || ($akses == 5))) { ?>
								<li><a href="<?php echo "$aksi?module=close&&kode_svc=$r[kode_svc]" ?>" onclick="return confirm('Apakah anda yakin, ingin menutup data service <?php echo $r['kode_svc'];?> ?')"><i class="icon-remove"></i> Close</a></li>
								<?php } ?>
							</ul>
						</div>
					</td>
				</tr>
			<?php $no++;
				}
			} else {
		?>
			<tr><td colspan="12"><div class="alert alert-error">Data tidak ditemukan</div></td></tr>
		<?php 
			}
		?>
		</tbody>
	</table>
</div>