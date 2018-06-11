<?php
	$aksi = "mod_stnk/aksi_stnk.php";
	switch ($_GET['act']) {
		default:
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox keyup
				$("#txtcari").keyup(function(){
					var strcari = $("#txtcari").val();
					var akses = $("#akses").val();
					if (strcari != "") {
						$("#tabel_awal").css("display","none");
						$("#hasil").html("<img src='assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_stnk/cari.php",
							data: "q="+strcari+"&akses="+akses,
							success: function(data){
								$("#hasil").css("display","block");
								$("#hasil").html(data);
							}
						});
					} else {
						$("#hasil").css("display","none");
						$("#tabel_awal").css("display","block");
					}
				});
			});
		</script>
	<?php
		$p = new Paging;
		$batas = 10;
		$posisi = $p->cariPosisi($batas);
	?>
		<section>
			<input type="hidden" value="<?php echo $_SESSION['akses'] ?>" id="akses">
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li class="active">Data Perp. STNK</li>
			</ul>
			<div class="control-group pull-left">
				<button class="btn btn-success" type="button" onclick="window.location='media.php?module=stnk&&act=tambah'"><i class="icon-chevron-right icon-white"></i> Input Perpanjangan</button>
			</div>
			<form class="form-search pull-right">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-search"></i></span>
					<input class="span3" id="txtcari" type="text" placeholder="Search ..."></input>
				</div>
			</form>
			<hr>
			<div class="row-fluid">
				<div class="span12 pull-left">
					<div id="hasil"></div>
					<div id="tabel_awal">
						<table class="table table-striped">
							<thead>
								<tr class="head2">
									<td>No.</td>
									<td>Kode Perpanjangan</td>
									<td>Plat No Mobil</td>
									<td>Nama Pemilik</td>
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
								$query = mysqli_query($conn, "SELECT * FROM perp_stnk, mobil, pegawai WHERE perp_stnk.id_mobil=mobil.id_mobil AND mobil.id_peg=pegawai.id_peg ORDER BY id_stnk DESC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php echo $r['kode_perp_stnk'];?></td>
									<td><?php echo $r['plat_no'];?></td>
									<td><?php echo $r['nama_peg'];?></td>
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
										<button class="btn btn-warning" onclick="window.location='media.php?module=stnk&&act=cost_real&&kode_perp_stnk=<?php echo $r['kode_perp_stnk'] ?>'" <?php if ($r['status'] != 'APPROVED_2') { ?> disabled <?php } ?>>Input Realisasi Biaya</button>
									</td>
									<?php } else { ?>
									<td><?php echo format_rupiah($r['cost_real']) ?></td>
									<?php } ?>

									<td>
										<div class="btn-group">
											<a class="btn btn-success" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<?php if (($r['status'] == 'REQUESTED') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
												<li><a href="<?php echo "$aksi?module=approve_1&&kode_perp_stnk=$r[kode_perp_stnk]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui perpanjangan STNK <?php echo $r['kode_perp_stnk'] ?> ?')"><i class="icon-pencil"></i> Approve_1</a></li>
												<?php } ?>

												<?php if (($r['status'] == 'APPROVED_1') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
												<li><a href="<?php echo "$aksi?module=approve_2&&kode_perp_stnk=$r[kode_perp_stnk]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui perpanjangan STNK <?php echo $r['kode_perp_stnk'] ?> ?')"><i class="icon-pencil"></i> Approve_2</a></li>
												<?php } ?>

												<?php if ($akses == 3) { ?>
												<li><a href="<?php echo "$aksi?module=hapus&&kode_perp_stnk=$r[kode_perp_stnk]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data perpanjangan STNK <?php echo $r['kode_perp_stnk'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
												<?php } ?>
												
												<?php if ($r['status'] == 'APPROVED_2') { ?>
												<li><a href="voucher/v_stnk.php?kode_perp_stnk=<?php echo $r['kode_perp_stnk'] ?>" onclick="window.location='voucher/v_stnk.php?kode_perp_stnk=<?php echo $r['kode_perp_stnk'] ?>"><i class="icon-print"></i> Print</a></li>
												<?php } ?>

												<?php if (($r['status'] == 'APPROVED_2') && (($akses == 3) || ($akses == 5))) { ?>
												<li><a href="<?php echo "$aksi?module=close&&kode_perp_stnk=$r[kode_perp_stnk]" ?>" onclick="return confirm('Apakah anda yakin, ingin menutup data perpanjangan STNK <?php echo $r['kode_perp_stnk'];?> ?')"><i class="icon-remove"></i> Close</a></li>
												<?php } ?>
											</ul>
										</div>
									</td>
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="9">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM perp_stnk"));
										$jmlhalaman = $p->jumlahHalaman($jmldata,$batas);
										$linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
										echo "$linkHalaman";
									?>
										<td>Jumlah Record <?php echo $jmldata;?></td>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
<?php
	break;
		case "tambah":
		$time_stamp = date("sdy");
		$acak1 = $time_stamp;

		function acakangkahuruf($panjang) {
			$karakter = '0123456789';
			$string = '';
			for ($i = 0; $i < $panjang; $i++) {
				$pos = rand(0, strlen($karakter)-1);
				$string .= $karakter{$pos};
			}
			return $string;
		}

		$acak2 = acakangkahuruf(3);
		$nounik = "STNK-".$acak1.$acak2;
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=stnk">Data Perp. STNK</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Perpanjangan STNK</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<input class="span10" type="hidden" id="inputText" value="<?php echo $kodeuser;?>" name="kode_user"></input>
						<fieldset>
							<legend class="span7 offset1">Input Perp. STNK</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Perp. STNK</label>
									<div class="controls">
										<input class="span6" type="text" value="<?php echo $nounik;?>" disabled></input>
										<input class="span6" type="hidden" value="<?php echo $nounik;?>" name="kode_perp_stnk"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Tanggal</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" value="<?php echo tgl_indo(date('Y-m-d')) ?>" disabled></input>
									</div>
								</div>						
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Mobil</label>
									<select name="id_mobil" class="span10" id="id_mobil" required>
										<div class="controls">
											<option>~ Mobil ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM mobil");
												;
												while ($mbl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $mbl['id_mobil'] ?>"><?php echo $mbl['plat_no'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Estimasi Biaya</label>
									<div class="controls">
										<input class="span10" type="text" name="cost_est" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
		case "cost_real":
		$kode_perp_stnk = $_GET['kode_perp_stnk'];
		$query = mysqli_query($conn, "SELECT * FROM perp_stnk WHERE perp_stnk.kode_perp_stnk='$kode_perp_stnk'");
		$row = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=stnk">Data Perp. STNK</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Realisasi Biaya Perpanjangan STNK</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=cost_real" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Realisasi Biaya Perp. STNK</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Perp. STNK</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $row['kode_perp_stnk']; ?>" disabled></input>
										<input class="span6" type="hidden" id="inputText" value="<?php echo $row['kode_perp_stnk']; ?>" name="kode_perp_stnk"></input>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="inputPassword">Plat No</label>
									<?php
										$query2 = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = '$row[id_mobil]'");
										$r = mysqli_fetch_array($query2);
									?>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $r['plat_no']; ?>" disabled></input>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="inputPassword">Owner</label>
									<?php
										$query3 = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_peg = '$r[id_peg]'");
										$rr = mysqli_fetch_array($query3);
									?>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $rr['nama_peg']; ?>" disabled></input>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="inputPassword">Cost Estimation</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo format_rupiah($row['cost_est']); ?>" disabled></input>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="inputPassword">Cost Realization</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" name="cost_real"></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
<?php
	break;
	}
?>