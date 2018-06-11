<?php
	$aksi = "mod_gs/aksi_gs.php";
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
						$("#hasil").html("<img src='assets/assets/images/loader.gif'/>")
						$.ajax({
							type: "POST",
							url : "mod_gs/cari.php",
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
				<li class="active">Data Ganti Sparepart</li>
			</ul>
			
			<div class="control-group pull-left">
				<button class="btn btn-info" type="button" onclick="window.location='media.php?module=ganti_sparepart&&act=tambah'"><i class="icon-chevron-right icon-white"></i> Input Ganti Sparepart</button>
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
								<tr class="head">
									<td>No.</td>
									<td>Kode Voucher</td>
									<td>Plat No Mobil</td>
									<td>Nama Pemilik</td>
									<td>Bengkel</td>
									<td>Nama Sparepart</td>
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
								$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, mobil, bengkel, pegawai WHERE ganti_sparepart.id_mobil=mobil.id_mobil AND ganti_sparepart.id_bkl=bengkel.id_bkl AND mobil.id_peg=pegawai.id_peg ORDER BY req_date DESC LIMIT $posisi, $batas");
								$no = $posisi+1;
								while ($r = mysqli_fetch_array($query)) {
							?>
								<tr>
									<td><?php echo $no.".";?></td>
									<td><?php echo $r['kode_spr'];?></td>
									<td><?php echo $r['plat_no'];?></td>
									<td><?php echo $r['nama_peg'];?></td>
									<td><?php echo $r['nama_bkl'];?></td>
									<td>
										<button class="btn btn-warning" onclick="window.location='media.php?module=ganti_sparepart&&act=input_sparepart&&kode_spr=<?php echo $r['kode_spr'] ?>&&id_mobil=<?php echo $r['id_mobil'] ?>'" <?php if ($r['status'] != "REQUESTED") { ?> disabled <?php } ?>><i class="icon-wrench icon-white"></i> Input Sparepart</button>
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

									<td><?php echo format_rupiah($r['cost_est']);?></td>

									<?php if ($r['cost_real'] == 0) { ?>
									<td>
										<button class="btn btn-warning" onclick="window.location='media.php?module=ganti_sparepart&&act=cost_real&&kode_spr=<?php echo $r['kode_spr'] ?>'" <?php if ($r['status'] != 'APPROVED_2') { ?> disabled <?php } ?>>Input Realisasi Biaya</button>
									</td>
									<?php } else { ?>
									<td><?php echo format_rupiah($r['cost_real']) ?></td>
									<?php } ?>

									<td>
										<div class="btn-group">
											<a class="btn btn-info" href="#"><i class="icon-wrench icon-white"></i> Actions</a>
											<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="media.php?module=ganti_sparepart&&act=detail&&kode_spr=<?php echo $r['kode_spr'];?>&&id_mobil=<?php echo $r['id_mobil'] ?>"><i class="icon-wrench"></i> Detail</a></li>

												<?php if (($r['status'] == 'REQUESTED') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
												<li><a href="<?php echo "$aksi?module=approve_1&&kode_spr=$r[kode_spr]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui pengajuan ganti sparepart <?php echo $r['kode_spr'] ?> ?')"><i class="icon-pencil"></i> Approve_1</a></li>
												<?php } ?>

												<?php if (($r['status'] == 'APPROVED_1') && ($akses == 3) && ($r['cost_est'] > 0)) { ?>
												<li><a href="<?php echo "$aksi?module=approve_2&&kode_spr=$r[kode_spr]&&kodeuser=$kodeuser";?>" onclick="return confirm('Apakah anda yakin, menyetujui pengajuan ganti sparepart <?php echo $r['kode_spr'] ?> ?')"><i class="icon-pencil"></i> Approve_2</a></li>
												<?php } ?>

												<?php if ($akses == 3) { ?>
												<li><a href="<?php echo "$aksi?module=hapus&&kode_spr=$r[kode_spr]";?>" onclick="return confirm('Apakah anda yakin, ingin menghapus data ganti sparepart <?php echo $r['kode_spr'];?> ?')"><i class="icon-trash"></i> Delete</a></li>
												<?php } ?>

												<?php if ($r['status'] == 'APPROVED_2') { ?>
												<li><a href="voucher/v_sparepart.php?kode_spr=<?php echo $r['kode_spr'] ?>" onclick="window.location='voucher/v_sparepart.php?kode_spr=<?php echo $r['kode_spr'] ?>"><i class="icon-print"></i> Print</a></li>
												<?php } ?>

												<?php if ($r['status'] == 'APPROVED_2' && $r['cost_real'] != 0) { ?>
												<li><a href="<?php echo "$aksi?module=close&&kode_spr=$r[kode_spr]" ?>" onclick="return confirm('Apakah anda yakin, ingin menutup data ganti sparepart <?php echo $r['kode_spr'];?> ?')"><i class="icon-remove"></i> Close</a></li>
												<?php } ?>
											</ul>
										</div>
									</td>
								</tr>
							<?php $no++;
								}
							?>
								<tr>
									<td colspan="11">
									<?php
										$jmldata = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ganti_sparepart"));
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
		$nounik = "SPR-".$acak1.$acak2;
?>		
		<section>
			<ul class="breadcrumb" style="margin-bottom:5px;">
				<li><a href="media.php?module=ganti_sparepart">Data Ganti Sparepart</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Ganti Sparepart</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=tambah";?>">
						<input class="span10" type="hidden" id="inputText" value="<?php echo $kodeuser;?>" name="kode_user"></input>
						<fieldset>
							<legend class="span7 offset1">Input Ganti Sparepart</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Voucher</label>
									<div class="controls">
										<input class="span6" type="text" value="<?php echo $nounik;?>" disabled></input>
										<input class="span6" type="hidden" value="<?php echo $nounik;?>" name="kode_spr"></input>
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
									<label class="control-label" for="inputPassword">Bengkel</label>
									<select name="id_bkl" class="span10" required>
										<div class="controls">
											<option>~ Bengkel ~</option>
											<?php
												$query = mysqli_query($conn, "SELECT * FROM bengkel");
												;
												while ($bkl = mysqli_fetch_array($query)) {
											?>
												<option value="<?php echo $bkl['id_bkl'] ?>"><?php echo $bkl['nama_bkl'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Mobil</label>
									<select name="id_mobil" class="span10" required>
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
		case "input_sparepart":
		$kode_spr = $_GET['kode_spr'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, bengkel WHERE ganti_sparepart.kode_spr='$kode_spr' AND ganti_sparepart.id_bkl=bengkel.id_bkl");
		$row = mysqli_fetch_array($query);
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox change
				$("#id_spr").change(function(){
					var id_spr = $("#id_spr").val();
					var id_mobil = $("#id_mobil").val();
					if (id_spr != "") {
						$("#harga").css("display","none");
						$("#hasil_harga").html("<img src='assets/assets/images/loader.gif'/>");
						$("#bulan").css("display","none");
						$("#hasil_bulan").html("<img src='assets/assets/images/loader.gif'/>");
						$.ajax({
							type: "POST",
							url : "mod_gs/cari_harga.php",
							data: "q="+id_spr,
							success: function(data){
								$("#hasil_harga").css("display","block");
								$("#hasil_harga").html(data);
							}
						});
						$.ajax({
							type: "POST",
							url : "mod_gs/cari_bulan.php",
							data: "q="+id_spr+"&r="+id_mobil,
							success: function(data){
								$("#hasil_bulan").css("display","block");
								$("#hasil_bulan").html(data);
							}
						});
					} else {
						$("#hasil_harga").css("display","none");
						$("#harga").css("display","block");
						$("#hasil_bulan").css("display","none");
						$("#bulan").css("display","block");
					}
				});
			});
		</script>

		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=ganti_sparepart">Data Ganti Sparepart</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Nama Sparepart</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=input_sparepart" ?>">
						<fieldset>
							<input class="span10" type="hidden" id="id_mobil" value="<?php echo $row['id_mobil'];?>" name="id_mobil"></input>
							<legend class="span7 offset1">Input Nama Sparepart</legend>
							<div class="clear"></div>
							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Voucher</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $row['kode_spr']; ?>" disabled></input>
										<input class="span6" type="hidden" id="inputText" value="<?php echo $row['kode_spr']; ?>" name="kode_spr"></input>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Bengkel</label>
									<div class="controls">
										<input class="span10" type="text" id="inputText" value="<?php echo $row['nama_bkl']; ?>" disabled></input>
									</div>
								</div>
								<div class="control-group">
									<label>Nama Sparepart</label>
									<select name="id_sprt" class="span10" id="id_spr">
										<div class="controls">
											<option>~ Nama Sparepart ~</option>
											<?php
												$bkl = $row['id_bkl'];
												$sprt = mysqli_query($conn, "SELECT * FROM sparepart WHERE sparepart.id_bkl='$bkl'");
												while ($spr = mysqli_fetch_array($sprt)) {
											?>
												<option value="<?php echo $spr['id_sprt'] ?>"><?php echo $spr['nama_sprt'] ?></option>
											<?php } ?>
										</div>
									</select>
								</div>
							</div>
							<div class="span3" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group" id="harga">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $spr['harga_sprt']; ?>" disabled></input>
									</div>
								</div>
								<div id="hasil_harga"></div>
								<div class="control-group" id="bulan">
									<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
									<label class="control-label" for="inputPassword">Tgl Terakhir Ganti Sparepart</label>
									<div class="controls">
										<input class="span7" type="text" id="inputText" disabled></input>
									</div>
								</div>
								<div id="hasil_bulan"></div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Jumlah</label>
									<div class="controls">
										<input class="span7" type="text" id="inputText" name="jumlah" required></input>
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
		case "detail":
		$kode_spr = $_GET['kode_spr'];
		$id_mobil = $_GET['id_mobil'];
		$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, bengkel WHERE ganti_sparepart.kode_spr='$kode_spr' AND ganti_sparepart.id_bkl=bengkel.id_bkl");
		$row = mysqli_fetch_array($query);
?>
		<script type="text/javascript">
			$(document).ready(function(){
				<!-- event textbox change
				$("#id_spr").change(function(){
					var id_spr = $("#id_spr").val();
					var id_mobil = $("#id_mobil").val();
					if (id_spr != "") {
						$("#harga").css("display","none");
						$("#hasil_harga").html("<img src='assets/images/loader.gif'/>");
						$("#bulan").css("display","none");
						$("#hasil_bulan").html("<img src='assets/images/loader.gif'/>");
						$.ajax({
							type: "POST",
							url : "mod_gs/cari_harga.php",
							data: "q="+id_spr,
							success: function(data){
								$("#hasil_harga").css("display","block");
								$("#hasil_harga").html(data);
							}
						});
						$.ajax({
							type: "POST",
							url : "mod_gs/cari_bulan.php",
							data: "q="+id_spr+"&r="+id_mobil,
							success: function(data){
								$("#hasil_bulan").css("display","block");
								$("#hasil_bulan").html(data);
							}
						});
					} else {
						$("#hasil_harga").css("display","none");
						$("#harga").css("display","block");
						$("#hasil_bulan").css("display","none");
						$("#bulan").css("display","block");
					}
				});
			});
		</script>

		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=ganti_sparepart">Data Ganti Sparepart</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Nama Sparepart</li>
			</ul>
			<div class="span5 pull-left">
				<div class="row-fluid">
					<div class="span12">
						<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=input_sparepart" ?>">
							<fieldset <?php if ($row['status'] == "APPROVED") { ?> disabled <?php } ?>>
								<legend class="span12">Input Nama Sparepart</legend>
								<div class="clear"></div>
								<div class="span8" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
									<div class="control-group">
										<label class="control-label" for="inputPassword">Kode Voucher</label>
										<div class="controls">
											<input class="span6" type="text" id="inputText" value="<?php echo $row['kode_spr']; ?>" disabled></input>
											<input class="span6" type="hidden" id="inputText" value="<?php echo $row['kode_spr']; ?>" name="kode_spr"></input>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="inputPassword">Bengkel</label>
										<div class="controls">
											<input class="span10" type="text" id="inputText" value="<?php echo $row['nama_bkl']; ?>" disabled></input>
										</div>
									</div>
									<div class="control-group">
										<label>Nama Sparepart</label>
										<select name="id_sprt" class="span10" id="id_spr">
											<div class="controls">
												<option>~ Nama Sparepart ~</option>
												<?php
													$bkl = $row['id_bkl'];
													$sparepart = mysqli_query($conn, "SELECT * FROM sparepart WHERE sparepart.id_bkl='$bkl'");
													while ($sprt = mysqli_fetch_array($sparepart)) {
												?>
													<option value="<?php echo $sprt['id_sprt'] ?>"><?php echo $sprt['nama_sprt'] ?></option>
												<?php } ?>
											</div>
										</select>
									</div>
									<div class="control-group" id="harga">
									<label class="control-label" for="inputPassword">Harga</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $spr['harga_sprt']; ?>" disabled></input>
									</div>
								</div>
								<div id="hasil_harga"></div>
								<div class="control-group" id="bulan">
									<input class="span10" type="hidden" id="id_mobil" value="<?php echo $id_mobil;?>" name="id_mobil"></input>
									<label class="control-label" for="inputPassword">Tgl Terakhir Ganti Sparepart</label>
									<div class="controls">
										<input class="span7" type="text" id="inputText" disabled></input>
									</div>
								</div>
								<div id="hasil_bulan"></div>
								<div class="control-group">
									<label class="control-label" for="inputPassword">Jumlah</label>
									<div class="controls">
										<input class="span7" type="text" id="inputText" name="jumlah" required></input>
									</div>
								</div>
								<hr>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-success" type="submit"><i class="icon-ok-circle icon-white"></i> Simpan</button>
										<button class="btn btn-warning" type="reset"><i class="icon-refresh icon-white"></i> Reset</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<div class="span6 pull-right" style="margin-right: 45px">
				<div class="row-fluid">
					<div class="span12">
						<div id="tabel_awal">
							<fieldset>
								<legend class="span12">Jenis Service yang dipilih</legend>
								<table class="table table-striped">
									<thead>
										<tr class="head3">
											<td>No.</td>
											<td>Nama Service</td>
											<td style="text-align: center">Harga</td>
											<td style="text-align: center">Jumlah</td>
											<td style="text-align: center">Total Harga</td>
										</tr>
									</thead>
									<tbody>
										<tr>
										<?php
											$no = 1;
											$detail = mysqli_query($conn, "SELECT * FROM detail_gs, sparepart WHERE detail_gs.kode_spr='$kode_spr' AND detail_gs.id_sprt=sparepart.id_sprt");
											while ($det = mysqli_fetch_array($detail)) { ?>
											<td><?php echo $no."." ?></td>
											<td><?php echo $det['nama_sprt'] ?> <?php if ($det['nama_sprt'] == 'Ban') { ?><sup><b>(<?php echo $det['arr_kode_ban'] ?>)</b></sup> <?php } ?></td>
											<td align="right" style="text-align: right"><?php echo format_rupiah($det['harga_sprt']) ?></td>
											<td style="text-align: right"><?php echo $det['jumlah'] ?></td>
											<td style="text-align: right"><?php echo format_rupiah($det['jumlah']*$det['harga_sprt']) ?></td>
										</tr>
										<?php $no++; } ?>
										<tr>
											<td colspan="4">Total Harga</td>
											<td style="text-align: right"><?php 
											$total_harga = $row['cost_est'];
												echo format_rupiah($total_harga); ?></td>
										</tr>
									</tbody>
								</table>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php
	break;
		case "cost_real":
		$kode_spr = $_GET['kode_spr'];
		$query = mysqli_query($conn, "SELECT * FROM ganti_sparepart, bengkel WHERE ganti_sparepart.kode_spr='$kode_spr' AND ganti_sparepart.id_bkl=bengkel.id_bkl");
		$row = mysqli_fetch_array($query);
?>
		<section>
			<ul class="breadcrumb" style="margin-bottom: 5px">
				<li><a href="media.php?module=service_mobil">Data Service</a> <span class="divider"><b>&gt;</b></span></li>
				<li class="active">Input Realisasi Biaya Service</li>
			</ul>

			<div class="row-fluid">
				<div class="span12 pull-left">
					<form method="post" enctype="multipart/form-data" action="<?php echo "$aksi?module=cost_real" ?>">
						<fieldset>
							<legend class="span7 offset1">Input Realisasi Biaya Service</legend>
							<div class="clear"></div>

							<div class="span3 offset1" style="border:1px solid #fff; border-radius:5px; padding:10px; background:#54c7dc">
								<div class="control-group">
									<label class="control-label" for="inputPassword">Kode Service</label>
									<div class="controls">
										<input class="span6" type="text" id="inputText" value="<?php echo $row['kode_spr']; ?>" disabled></input>
										<input class="span6" type="hidden" id="inputText" value="<?php echo $row['kode_spr']; ?>" name="kode_spr"></input>
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